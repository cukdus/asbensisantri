<html>

<head>
   <title>Rekap absen <?= $grup ?></title>
   <style>
      body {
         font-family: Arial, Helvetica, sans-serif;
         margin: 0;
      }

      table {
         border-collapse: collapse;
      }

      /* Konsistensi ukuran logo di PDF & DOC */
      .logo-img {
         width: 2.65cm; /* ~100px pada 96 DPI */
         height: auto;
      }

      /* Orientasi cetak: Landscape untuk PDF (browser print) */
      @page {
         size: A4 landscape;
         margin: 10mm;
      }


      /* Kompatibilitas Microsoft Word (.doc via HTML) */
      @page Section1 {
         size: 29.7cm 21cm; /* A4 Landscape */
         mso-page-orientation: landscape;
         margin: 1cm;
      }
      .Section1 { page: Section1; }
   </style>
</head>


<body>

   <div class="Section1">
      <?= $this->renderSection('content') ?>
   </div>

</body>

</html>