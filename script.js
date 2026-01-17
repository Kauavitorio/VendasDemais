document.addEventListener('DOMContentLoaded', () => {
  const products = window.initialData || [];
  const state = {
    itemsPerPage: 12,
    currentPage: 1,
    activeTag: null,
    searchQuery: ''
  };

  const els = {
    grid: document.getElementById('grid'),
    tags: document.getElementById('tags-container'),
    prev: document.getElementById('prev'),
    next: document.getElementById('next'),
    pages: document.getElementById('pages'),
    search: document.getElementById('q'),
    year: document.getElementById('year')
  };

  // Set Year
  if(els.year) els.year.textContent = new Date().getFullYear();

  // Extract Tags
  const allTags = new Set();
  products.forEach(p => {
    if (p.tags && Array.isArray(p.tags)) {
      p.tags.forEach(t => allTags.add(t));
    }
  });

  // Render Tags
  if (els.tags) {
    const tagsHtml = Array.from(allTags).map(tag => 
      `<button class="tag" data-tag="${tag}">${tag}</button>`
    ).join('');
    els.tags.innerHTML = `<button class="tag active" data-tag="all">Todos</button>${tagsHtml}`;

    els.tags.querySelectorAll('.tag').forEach(btn => {
      btn.addEventListener('click', () => {
        const tag = btn.dataset.tag;
        state.activeTag = tag === 'all' ? null : tag;
        state.currentPage = 1;

        // Update UI
        els.tags.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        render();
      });
    });
  }

  // Search
  if (els.search) {
    els.search.addEventListener('input', (e) => {
      state.searchQuery = e.target.value.toLowerCase();
      state.currentPage = 1;
      render();
    });
  }

  // Pagination interaction
  if (els.prev) {
    els.prev.addEventListener('click', () => {
      if (state.currentPage > 1) {
        state.currentPage--;
        render();
      }
    });
  }

  if (els.next) {
    els.next.addEventListener('click', () => {
      const filtered = getFilteredProducts();
      const maxPage = Math.ceil(filtered.length / state.itemsPerPage);
      if (state.currentPage < maxPage) {
        state.currentPage++;
        render();
      }
    });
  }

  function getFilteredProducts() {
    return products.filter(p => {
      const matchesSearch = p.name.toLowerCase().includes(state.searchQuery) || 
                            (p.description && p.description.toLowerCase().includes(state.searchQuery));
      const matchesTag = state.activeTag ? (p.tags && p.tags.includes(state.activeTag)) : true;
      return matchesSearch && matchesTag;
    });
  }

  function render() {
    const filtered = getFilteredProducts();
    const totalPages = Math.ceil(filtered.length / state.itemsPerPage);
    
    // Clamp page
    if (state.currentPage > totalPages) state.currentPage = totalPages || 1;

    // Slice
    const start = (state.currentPage - 1) * state.itemsPerPage;
    const end = start + state.itemsPerPage;
    const pageItems = filtered.slice(start, end);

    // Render Grid
    if (pageItems.length === 0) {
      els.grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: var(--muted); padding: 2rem;">Nenhum produto encontrado.</p>';
    } else {
      els.grid.innerHTML = pageItems.map(p => `
        <a href="${p.link || '#'}" class="product-item">
          <div class="product-img-wrapper">
             <img src="${p.image}" alt="${p.name}" class="product-img" loading="lazy">
          </div>
          <div class="product-info">
            <div class="product-name">${p.name}</div>
            <div class="product-desc">${p.description || ''}</div>
            <div class="product-footer">
                <div class="product-btn">Comprar</div>
            </div>
          </div>
        </a>
      `).join('');
    }

    // Render Pagination Controls
    if (els.pages) {
      // Simple dots for now, or just numbers
      let pagesHtml = '';
      for (let i = 1; i <= totalPages; i++) {
        pagesHtml += `<button class="page-btn ${i === state.currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
      }
      els.pages.innerHTML = pagesHtml;
      
      els.pages.querySelectorAll('.page-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          state.currentPage = parseInt(btn.dataset.page);
          render();
        });
      });
    }

    // Update Arrows
    if (els.prev) els.prev.disabled = state.currentPage === 1;
    if (els.next) els.next.disabled = state.currentPage === totalPages || totalPages === 0;
  }

  // Initial Render
  render();
});
