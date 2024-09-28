<!DOCTYPE html>

<?php
$page = "Page Modul";
$id = $_GET['id'];
?>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDF Viewer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    #pdf-viewer {
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    #toolbar {
      background: #4CAF50;
      color: white;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #pdf-render {
      flex: 1;
      overflow: auto;
      /* Enable scroll for overflow */
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #e4e4e4;
      transition: padding-top 0.3s ease;
    }

    #page-num {
      margin-left: 10px;
    }

    canvas {
      border: 1px solid black;
    }

    .controls {
      display: flex;
      align-items: center;
    }
  </style>
</head>

<body>

  <div id="pdf-viewer">
    <div id="toolbar">
      <div class="controls">
        <button id="prev-page"><i class="fas fa-arrow-left"></i></button>
        <span>Page: <span id="page-num">1</span> / <span id="page-count"></span></span>
        <button id="next-page"><i class="fas fa-arrow-right"></i></button>
      </div>
      <div class="controls">
        <button id="zoom-in"><i class="fas fa-search-plus"></i></button>
        <button id="zoom-out"><i class="fas fa-search-minus"></i></button>
        <button id="back"><i class="fas fa-arrow-left"></i></button>
      </div>
    </div>
    <div id="pdf-render" style="padding-top: 400px;"></div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
  <script>
    document.getElementById("back").addEventListener("click", function() {
      window.history.back();
    });
  </script>
  <script>
    const url = 'http://localhost/smom/assets/pdf/uploads/<?= $id ?>'; // Replace with your actual PDF path

    let pdfDoc = null,
      pageNum = 1,
      pageIsRendering = false,
      pageNumIsPending = null,
      scale = 1.5, // Start with default zoom
      canvas = document.createElement('canvas'),
      ctx = canvas.getContext('2d'),
      paddingTop = 600; // Variable to track padding-top

    document.getElementById('pdf-render').appendChild(canvas);

    // Render the page
    const renderPage = num => {
      pageIsRendering = true;

      // Get the page
      pdfDoc.getPage(num).then(page => {
        const viewport = page.getViewport({
          scale
        });

        // Set canvas dimensions based on viewport
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Reset scroll position after zoom
        document.getElementById('pdf-render').scrollTop = 0;
        document.getElementById('pdf-render').scrollLeft = 0;

        const renderCtx = {
          canvasContext: ctx,
          viewport
        };

        page.render(renderCtx).promise.then(() => {
          pageIsRendering = false;

          if (pageNumIsPending !== null) {
            renderPage(pageNumIsPending);
            pageNumIsPending = null;
          }
        });

        // Output current page
        document.getElementById('page-num').textContent = num;
      });
    };

    // Check for pages rendering
    const queueRenderPage = num => {
      if (pageIsRendering) {
        pageNumIsPending = num;
      } else {
        renderPage(num);
      }
    };

    // Show Prev Page
    document.getElementById('prev-page').addEventListener('click', () => {
      if (pageNum <= 1) {
        return;
      }
      pageNum--;
      queueRenderPage(pageNum);
    });

    // Show Next Page
    document.getElementById('next-page').addEventListener('click', () => {
      if (pageNum >= pdfDoc.numPages) {
        return;
      }
      pageNum++;
      queueRenderPage(pageNum);
    });

    // Zoom In
    document.getElementById('zoom-in').addEventListener('click', () => {
      scale += 0.25; // Increase zoom level
      paddingTop += 100; // Increase padding-top by 100px
      document.getElementById('pdf-render').style.paddingTop = paddingTop + 'px';
      queueRenderPage(pageNum); // Re-render current page with new zoom
    });

    // Zoom Out
    document.getElementById('zoom-out').addEventListener('click', () => {
      if (scale > 0.5) { // Prevent zooming out too much
        scale -= 0.25; // Decrease zoom level
        paddingTop = Math.max(0, paddingTop - 100); // Decrease padding-top by 100px, but not less than 0
        document.getElementById('pdf-render').style.paddingTop = paddingTop + 'px';
        queueRenderPage(pageNum); // Re-render current page with new zoom
      }
    });

    // Get Document
    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
      pdfDoc = pdfDoc_;
      document.getElementById('page-count').textContent = pdfDoc.numPages;

      renderPage(pageNum); // Render first page initially
    });
  </script>

</body>

</html>