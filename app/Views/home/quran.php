<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>
<style>
      /* Quran app styles adapted to match ponpes/quran.html */
      body {
        background-color: #f4f4f4;
        font-family: "Inter", sans-serif;
      }
      .quran-wrapper {
        display: flex;
        /* match original ponpes layout height */
        min-height: calc(100vh - 60px);
      }
      .sidebar {
        width: 300px;
        background: #fff;
        border-right: 1px solid #ddd;
        overflow-y: auto;
        padding-bottom: 80px;
      }
      .sidebar h5 {
        background: #006633;
        color: #fff;
        padding: 10px 15px;
        margin: 0;
        font-size: 1rem;
      }
      .sidebar a {
        display: block;
        padding: 10px 15px;
        color: #333;
        border-bottom: 1px solid #f1f1f1;
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.2s ease;
      }
      .sidebar a:hover,
      .sidebar a.active {
        background: #006633;
        color: #fff;
      }
      .content {
        flex: 1;
        background: #fff;
        padding: 25px;
        overflow-y: auto;
      }
      .surah-header {
        border-bottom: 2px solid #006633;
        margin-bottom: 20px;
        padding-bottom: 10px;
      }
      .surah-header h2 {
        font-size: 1.6rem;
        font-weight: 600;
        margin: 0;
        color: #006633;
      }
      .surah-header p {
        color: #777;
        margin-top: 5px;
        font-size: 0.95rem;
      }
      .ayat {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
      }
      .ayat .arabic {
        text-align: right;
        font-family: "Noto Sans Arabic", serif;
        font-size: 1.6rem;
        color: #222;
        direction: rtl;
        line-height: 2.2rem;
      }
      .ayat .number {
        display: inline-block;
        background: #006633;
        color: #fff;
        font-size: 0.85rem;
        border-radius: 50%;
        padding: 5px 9px;
        margin-left: 5px;
      }
      .ayat .latin {
        font-style: italic;
        color: #888;
        font-size: 0.9rem;
        margin-top: 5px;
      }
      .ayat .translation {
        margin-top: 8px;
        color: #333;
        font-size: 1rem;
      }
      .loader {
        text-align: center;
        padding: 30px;
      }
      @media (max-width: 768px) {
        .quran-wrapper {
          flex-direction: column;
        }
        .sidebar {
          width: 100%;
          border-right: none;
          border-bottom: 1px solid #ddd;
        }
      }
      /* Additional layout & component styles from ponpes/online.html to match screenshot */
      .logo {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 1.6rem;
        font-weight: 700;
        color: #ffffffff;
      }
      .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2em;
      }
      .search-container {
        position: relative;
        width: 520px;
      }
      .search-input {
        width: 100%;
        padding: 12px 20px 12px 50px;
        border: 2px solid #e2e8f0;
        border-radius: 25px;
        font-size: 14px;
        outline: none;
        transition: all 0.3s ease;
      }
      .search-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
      }

      .quick-access {
        margin-bottom: 30px;
      }
      .quick-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 20px;
      }
      .quick-btn {
        background: #dcfce7;
        color: #166534;
        padding: 8px 20px;
        border-radius: 20px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
      }
      .quick-btn:hover {
        background: #bbf7d0;
        transform: translateY(-1px);
      }
      .quick-btn.active {
        background: #10b981;
        color: white;
      }

      .surah-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 20px;
      }
      .surah-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
      }
      .surah-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-color: #10b981;
      }
      .surah-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #10b981, #059669);
        opacity: 0.06;
        border-radius: 0 15px 0 50px;
      }
      .surah-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
      }
      .surah-number {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
      }
      .surah-arabic {
        font-size: 1.3rem;
        color: #059669;
        font-weight: 700;
        font-family: "Amiri", serif;
        text-align: right;
      }
      .surah-info h3 {
        font-size: 1.1rem;
        color: #1e293b;
        margin-bottom: 6px;
        font-weight: 600;
      }
      .surah-meta {
        color: #64748b;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .loading {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
      }
      .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #e2e8f0;
        border-left: 4px solid #10b981;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
      }
      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
      .error {
        background: #fef2f2;
        color: #dc2626;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin: 20px 0;
        border: 2px solid #fecaca;
      }

      .ayah-viewer {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
      }
      .ayah-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
      }
      .ayah-header h2 {
        color: #059669;
        font-size: 2em;
        margin-bottom: 10px;
      }
      .ayah-header p {
        color: #64748b;
        font-size: 1em;
      }
      .back-btn {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
      }
      .back-btn:hover {
        background: #e2e8f0;
        transform: translateX(-3px);
      }
      .ayah-item {
        padding: 25px;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.3s ease;
      }
      .ayah-item:hover {
        background: #f8fafc;
      }
      /* indicate currently playing ayah with same background as hover */
      .ayah-item.playing {
        background: #f8fafc;
        border: 2px solid #10b981;
        border-radius: 20px;
      }
      .ayah-number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        background: #10b981;
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 12px;
        margin-bottom: 15px;
      }
      .ayah-arabic {
        font-size: 1.6em;
        line-height: 2;
        text-align: right;
        margin-bottom: 15px;
        color: #1e293b;
        font-family: "Amiri", serif;
      }
      .ayah-translation {
        font-size: 1em;
        line-height: 1.7;
        color: #475569;
        font-style: italic;
      }

      .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
        flex-wrap: wrap;
      }
      .pagination button {
        background: white;
        color: #475569;
        border: 2px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
      }
      .pagination button:hover {
        background: #f8fafc;
        border-color: #10b981;
        color: #10b981;
      }
      .pagination button.active {
        background: #10b981;
        color: white;
        border-color: #10b981;
      }

      @media (max-width: 768px) {
        .surah-grid {
          grid-template-columns: 1fr;
        }
        .search-container {
          width: 100%;
          max-width: 520px;
        }
        .logo {
          font-size: 1.4rem;
        }
        .ayah-arabic {
          font-size: 1.4em;
        }
      }
      /* Align search to the right inside the main header on desktop, stack on mobile */
      .main > .header .header-content {
        justify-content: space-between;
      }
      .main > .header .search-container {
        margin-left: auto;
      }
      .main > .header .logo {
        margin-right: 12px;
      }
      @media (max-width: 768px) {
        .main > .header .header-content {
          flex-direction: column;
          align-items: stretch;
          gap: 10px;
        }
        .main > .header .search-container {
          margin-left: 0;
          width: 100%;
        }
        .main > .header .search-input {
          width: 100%;
          max-width: 100%;
        }
      }
      /* Scoped main header/search styles to match the screenshot */
      .main > .header {
        background: #10b981; /* strong green bar */
        padding: 18px 0;
      }
      .main > .header .header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
      }
      /* make the logo square with white background like screenshot */
      .main > .header .logo-icon {
        background: white;
        color: #059669;
        width: 44px;
        height: 44px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
      }
      /* search pill placed inside green bar, large, rounded and with shadow */
      /* make the search container take remaining space and right-align the input
         so the input sits flush to the right edge of the centered header-content */
      .main > .header .search-container {
        margin-left: auto; /* keep existing behavior */
        flex: 1; /* consume remaining horizontal space */
        display: flex;
        justify-content: flex-end; /* push children (the input) to the far right */
      }
      .main > .header .search-input {
        background: white;
        border-radius: 999px;
        padding: 14px 22px 14px 48px;
        width: 100%;
        max-width: 680px; /* cap the input width on large screens */
        box-shadow: 0 6px 18px rgba(2, 48, 32, 0.08);
        border: 0.5px solid rgba(6, 95, 70, 0.08);
      }
      .main > .header .search-input::placeholder {
        color: #6b7280;
      }

      /* Quick access row sits below the green bar, centered */
      .main .quick-access {
        background: transparent;
        padding: 18px 0 8px;
      }
      .main .quick-buttons {
        justify-content: center;
      }

      /* When viewing a surah, make the ayah viewer span the container's content width
         so it aligns with other .container children (surah-grid, quick-access). */
      .ayah-viewer {
        width: 100%;
        max-width: none;
        box-sizing: border-box;
        margin: 18px 0 40px; /* align to container flow, not centered narrower box */
      }
    </style>
    <main class="main" id="main-content" role="main" style="background-color: #f8fafc;">
      <!-- Replace content with ponpes/online.html content area -->
      <div class="header mb-4">
        <div class="header-content">
          <div class="logo">
            <div class="logo-icon">📖</div>
            <span>Al-Quran Online</span>
          </div>
          <div class="search-container">
            <input
              type="text"
              class="search-input"
              placeholder="🔍 Cari surah atau ayat..."
              id="searchInput"
              oninput="searchSurah()"
            />
          </div>
        </div>
      </div>

      <div class="container">
        <!-- Quick Access Buttons -->
        <div class="quick-access" id="quickAccess">
          <div class="quick-buttons">
            <button class="quick-btn" onclick="showSurah(36)">Yasin</button>
            <button class="quick-btn" onclick="showSurah(56)">
              Al-Waqi'ah
            </button>
            <button class="quick-btn" onclick="showSurah(67)">Al-Mulk</button>
            <button class="quick-btn" onclick="showSurah(18)">Al-Kahfi</button>
            <button class="quick-btn" onclick="showSurah(55)">Ar-Rahman</button>
            <button class="quick-btn" onclick="showAyahKursi()">
              Ayat Kursi
            </button>
          </div>
        </div>

        <!-- Content Area -->
        <div id="content">
          <!-- Surah list will be loaded here -->
        </div>
      </div>

      <script>
        let surahList = [];
        let filteredSurahs = [];
        let currentPage = 1;
        let currentView = "list";
        const ayahsPerPage = 10;
        let currentAudio = null;
        let currentSurah = null;
        let currentAyahIndex = null;
        let currentSurahAyat = [];

        window.addEventListener("load", function () {
          loadSurahList();
        });

        async function loadSurahList() {
          try {
            showLoading();

            const response = await fetch("https://equran.id/api/v2/surat");
            const data = await response.json();

            if (data.data) {
              surahList = data.data.map((surah) => ({
                number: surah.nomor,
                name_id: surah.namaLatin,
                name_ar: surah.nama,
                translation: surah.arti,
                ayah_count: surah.jumlahAyat,
                type: surah.tempatTurun,
              }));

              filteredSurahs = [...surahList];
              displaySurahList();
            } else {
              throw new Error("Gagal memuat daftar surah");
            }
          } catch (error) {
            showError(`Gagal memuat daftar surah: ${error.message}`);
          }
        }

        function displaySurahList() {
          currentView = "list";
          document.getElementById("quickAccess").classList.remove("hidden");

          const searchResults = document.getElementById("searchInput").value
            ? `<div class="search-results">Ditemukan ${filteredSurahs.length} surah</div>`
            : "";

          const surahCards = filteredSurahs
            .map(
              (surah) => `
          <div class="surah-card" onclick="showSurah(${surah.number})">
            <div class="surah-header">
              <div class="surah-number">${surah.number}</div>
              <div class="surah-arabic">${surah.name_ar}</div>
            </div>
            <div class="surah-info">
              <h3>${surah.name_id}</h3>
              <div class="surah-meta">
                <span>${surah.translation}</span>
                <span>• ${surah.ayah_count} ayat</span>
                <span>• ${surah.type}</span>
              </div>
            </div>
          </div>`
            )
            .join("");

          document.getElementById("content").innerHTML =
            searchResults + `<div class="surah-grid">${surahCards}</div>`;
        }

        async function showSurah(surahNumber) {
          try {
            showLoading();
            currentView = "surah";
            document.getElementById("quickAccess").classList.add("hidden");

            const response = await fetch(
              `https://equran.id/api/v2/surat/${surahNumber}`
            );
            const data = await response.json();
            const surah = data.data;

            currentSurah = surah;
            currentSurahAyat = surah.ayat;
            displaySurah(surah);
          } catch (error) {
            showError(`Gagal memuat surah: ${error.message}`);
          }
        }

        function displaySurah(surah) {
          currentPage = 1;
          const ayatList = surah.ayat;
          const paginatedAyahs = paginateAyahs(ayatList);
          const ayahsHtml = paginatedAyahs
            .map(
              (ayah, index) => `
          <div class="ayah-item" id="ayah-${index}">
            <div class="ayah-header-item d-flex align-items-center justify-content-between">
              <div class="ayah-number-badge">${ayah.nomorAyat}</div>
              <button class="audio-btn" onclick="playAudio(${index}, '${ayah.audio["05"]}')">
                ▶️ Putar
              </button>
            </div>
            <div class="ayah-arabic">${ayah.teksArab}</div>
            <div class="ayah-latin">${ayah.teksLatin}</div>
            <div class="ayah-translation">${ayah.teksIndonesia}</div>
          </div>`
            )
            .join("");

          const pagination = createPagination(ayatList.length, () =>
            displaySurah(surah)
          );

          document.getElementById("content").innerHTML = `
      <button class="back-btn" onclick="goBack()">← Kembali ke Daftar Surah</button>
      <div class="ayah-viewer">
        <div class="ayah-header">
          <h2>${surah.namaLatin} (${surah.nama})</h2>
          <p>${surah.arti} • ${surah.jumlahAyat} ayat • ${surah.tempatTurun}</p>
        </div>
        ${ayahsHtml}
      </div>
      ${pagination}`;
        }

        function playAudio(index, url) {
          const ayah = currentSurahAyat[index];

          // Pastikan semua ayat pakai Misyari Rasyid Al-Afasi
          const surahNumber = String(currentSurah.nomor).padStart(3, "0");
          const ayahNumber = String(ayah.nomorAyat).padStart(3, "0");
          const audioUrl = `https://cdn.equran.id/audio-partial/Misyari-Rasyid-Al-Afasi/${surahNumber}${ayahNumber}.mp3`;

          document
            .querySelectorAll(".ayah-item.playing")
            .forEach((item) => item.classList.remove("playing"));
          const activeAyah = document.getElementById(`ayah-${index}`);
          if (activeAyah) {
            activeAyah.classList.add("playing");
          }

          // Hentikan audio lama
          if (currentAudio) {
            currentAudio.pause();
            currentAudio = null;
          }

          // Hapus player lama
          const oldPlayer = document.getElementById("floatingAudioPlayer");
          if (oldPlayer) oldPlayer.remove();

          // Tambahkan player baru melayang
          const playerHTML = `
    <div id="floatingAudioPlayer" class="floating-audio">
      <div class="info">
        <strong>${currentSurah.namaLatin}</strong> — Ayat ${ayah.nomorAyat}
      </div>
      <audio id="quranAudio" controls autoplay src="${audioUrl}"></audio>
      <button class="close-player" onclick="closeAudio()">✖</button>
    </div>`;
          document.body.insertAdjacentHTML("beforeend", playerHTML);

          currentAudio = document.getElementById("quranAudio");
          currentAyahIndex = index;

          // Auto next ayat tetap pakai Misyari Rasyid
          currentAudio.onended = () => {
            const nextIndex = currentAyahIndex + 1;
            if (nextIndex < currentSurahAyat.length) {
              playAudio(nextIndex); // tidak perlu url dari API lagi
              document.getElementById(`ayah-${nextIndex}`).scrollIntoView({
                behavior: "smooth",
                block: "center",
              });
            } else {
              closeAudio();
            }
          };
        }

        function closeAudio() {
          if (currentAudio) currentAudio.pause();
          const player = document.getElementById("floatingAudioPlayer");
          if (player) player.remove();
          const playingAyah = document.querySelector(".ayah-item.playing");
          if (playingAyah) playingAyah.classList.remove("playing");
        }

        function searchSurah() {
          const query = document
            .getElementById("searchInput")
            .value.toLowerCase();

          if (!query) {
            filteredSurahs = [...surahList];
          } else {
            filteredSurahs = surahList.filter(
              (surah) =>
                surah.name_id.toLowerCase().includes(query) ||
                surah.translation.toLowerCase().includes(query) ||
                surah.number.toString().includes(query)
            );
          }

          if (currentView === "list") displaySurahList();
        }

        function goBack() {
          closeAudio();
          document.getElementById("searchInput").value = "";
          filteredSurahs = [...surahList];
          displaySurahList();
        }

        function paginateAyahs(ayahs) {
          const startIndex = (currentPage - 1) * ayahsPerPage;
          const endIndex = startIndex + ayahsPerPage;
          return ayahs.slice(startIndex, endIndex);
        }

        function createPagination(totalAyahs, callback) {
          const totalPages = Math.ceil(totalAyahs / ayahsPerPage);
          if (totalPages <= 1) return "";

          let html = '<div class="pagination">';
          if (currentPage > 1)
            html += `<button onclick="changePage(${
              currentPage - 1
            }, callback)">‹ Prev</button>`;
          for (let i = 1; i <= totalPages; i++) {
            html += `<button class="${
              i === currentPage ? "active" : ""
            }" onclick="changePage(${i}, callback)">${i}</button>`;
          }
          if (currentPage < totalPages)
            html += `<button onclick="changePage(${
              currentPage + 1
            }, callback)">Next ›</button>`;
          html += "</div>";
          return html;
        }

        function changePage(page, callback) {
          currentPage = page;
          callback();
        }

        function showLoading() {
          document.getElementById("content").innerHTML = `
      <div class="loading">
        <div class="spinner"></div>
        <p>Memuat...</p>
      </div>`;
        }

        function showError(message) {
          document.getElementById("content").innerHTML = `
      <div class="error">
        <h3>❌ Error</h3>
        <p>${message}</p>
        <button onclick="loadSurahList()" style="margin-top:15px;background:#dc2626;color:white;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;">Coba Lagi</button>
      </div>`;
        }
      </script>

      <style>
        .ayah-latin {
          font-size: 1rem;
          color: #64748b;
          font-style: italic;
          margin-top: 8px;
          margin-bottom: 10px;
        }

        .audio-btn {
          background: #f1f5f9;
          border: none;
          border-radius: 8px;
          padding: 6px 12px;
          cursor: pointer;
          transition: all 0.2s ease;
          font-size: 0.9rem;
        }

        .audio-btn:hover {
          background: #10b981;
          color: white;
        }

        /* === Floating Audio Player === */
        .floating-audio {
          position: fixed;
          bottom: 0;
          left: 0;
          right: 0;
          background: white;
          box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.15);
          padding: 10px 20px;
          display: flex;
          align-items: center;
          gap: 15px;
          z-index: 999;
          border-top: 3px solid #10b981;
        }

        .floating-audio .info {
          flex: 1;
          color: #065f46;
          font-weight: 600;
        }

        .floating-audio audio {
          flex: 2;
        }

        .floating-audio .close-player {
          background: none;
          border: none;
          color: #dc2626;
          font-size: 1.3rem;
          cursor: pointer;
        }
      </style>
    </main>

<?= $this->include('templates/footer_public') ?>