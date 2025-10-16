<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>
<style>
  .doa-wrapper { background: #f8fafc; min-height: calc(100vh - 60px); padding-bottom: 20px; }
  .header-bar { background: #10b981; padding: 18px 0; }
  .header-bar .container { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
  .logo { display: flex; align-items: center; gap: 12px; color: white; font-weight: 700; }
  .logo .logo-icon { background: white; color: #059669; width: 44px; height: 44px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .doa-wrapper .categories { display: grid; grid-template-columns: repeat(3, minmax(140px, 1fr)); gap: 10px; width: 100%; text-align: center; padding-top: 16px; }
    .doa-wrapper .category-btn { background: white; color: #334155; border: 2px solid #e2e8f0; padding: 10px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.2s ease; display: flex; flex-direction: column; align-items: center; gap: 6px; width: 100%; }
    .doa-wrapper .category-btn:hover { background: #f8fafc; }
    .doa-wrapper .category-btn.active { background: #10b981; color: white; border-color: #10b981; }
    .doa-wrapper .category-btn .cat-icon { font-size: 1.4rem; line-height: 1; }
    .doa-wrapper .category-btn .cat-label { font-size: 0.95rem; }
  .content { background: #f8fafc; }
    .doa-wrapper .filter-row { display: flex; flex-direction: column; align-items: stretch; gap: 8px; padding: 16px 0; }
    .doa-wrapper #groupFilter { width: 100%; }
  .doa-card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 12px; background: #fff; }
  .doa-card h3 { margin: 0 0 8px 0;}
  .doa-group { font-size: 12px; color: #64748b; margin-bottom: 8px; }
  .doa-ar { font-family: "Amiri", serif; font-size: 3rem; text-align: right; color: #1e293b; margin-bottom: 10px; }
  .doa-tr { font-style: italic; color: #475569; margin-bottom: 8px; }
  .doa-idn { color: #334155; }
  .doa-tentang { font-size: 12px; color: #64748b; margin-top: 10px; white-space: pre-wrap; }
</style>

<main class="doa-wrapper">
  <div class="container content">
    <div class="categories" id="categoriesBar">
      <button id="cat-quran" class="category-btn" onclick="window.location.href='/quran'">
        <span class="cat-icon">📖</span>
        <span class="cat-label">Al-Qur'an</span>
      </button>
      <button id="cat-yasin" class="category-btn" onclick="window.location.href='/quran?surah=36'">
        <span class="cat-icon">📜</span>
        <span class="cat-label">Yasin</span>
      </button>
      <button id="cat-doa" class="category-btn active">
        <span class="cat-icon">🤲</span>
        <span class="cat-label">Doa & Dzikir</span>
      </button>
    </div>
    <div class="filter-row">
      <label for="groupFilter" style="color:#334155;font-weight:600;">Filter Grup:</label>
      <select id="groupFilter" onchange="applyFilter()" style="padding:8px 10px;border:1px solid #e2e8f0;border-radius:8px;">
        <option value="ALL">Semua</option>
      </select>
    </div>
    <div id="doaList"></div>
  </div>
</main>

<script>
  let doaData = [];
  let groups = [];
  window.addEventListener('load', () => { loadDoa(); });

  async function loadDoa() {
    try {
      document.getElementById('doaList').innerHTML = '<p style="padding:16px;">Memuat data doa & dzikir...</p>';
      const res = await fetch('https://equran.id/api/doa');
      const json = await res.json();
      if (!json || !json.data) throw new Error('Gagal memuat data');
      doaData = json.data;
      const groupSet = new Set(doaData.map(item => item.grup).filter(Boolean));
      groups = Array.from(groupSet).sort();
      const sel = document.getElementById('groupFilter');
      groups.forEach(g => { const opt = document.createElement('option'); opt.value = g; opt.textContent = g; sel.appendChild(opt); });
      renderDoa(doaData);
    } catch (err) {
      document.getElementById('doaList').innerHTML = `<div class="doa-card"><h3>❌ Error</h3><p>${err.message}</p></div>`;
    }
  }

  function applyFilter() {
    const g = document.getElementById('groupFilter').value;
    const filtered = doaData.filter(item => {
      const matchGroup = g === 'ALL' || item.grup === g;
      return matchGroup;
    });
    renderDoa(filtered);
  }

  function renderDoa(list) {
    const html = list.map(item => `
      <div class="doa-card">
        <div class="doa-group">${item.grup || ''}</div>
        <h3>${item.nama}</h3>
        <div class="doa-ar">${item.ar || ''}</div>
        <div class="doa-tr">${item.tr || ''}</div>
        <div class="doa-idn">${item.idn || ''}</div>
        ${item.tentang ? `<div class="doa-tentang">${item.tentang}</div>` : ''}
      </div>
    `).join('');
    document.getElementById('doaList').innerHTML = html || '<p style="padding:16px;">Tidak ada data</p>';
  }
</script>

<?= $this->include('templates/footer_public') ?>