document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('#tabs li');
    const tabContent = document.getElementById('tab-content');
  
    const endpoints = {
      mostWanted: 'backend/mostviewed.php',
      recentlyAdded: 'backend/lastcreated.php',
      recentlySearched: 'backend/lastviewed.php',
    };
  
    const renderTable = (data) => {
      const rows = data.map(item => `
        <tr>
          <td><a href="number.php?number=${item.number}">${item.number}</a></td>
          <td><span>${item.views} 👁️</span></td>
          <td><a href="numbers${item.number}">${item.number}</a></td>
          <td><span>${item.comments} 💬</span></td>
        </tr>
      `).join('');
  
      return `<table class="table-container"><tbody>${rows}</tbody></table>`;
    };
  
    const renderPills = (data) => {
      return `
        <div class="number-list">
          ${data.map(num => `
            <a href="number.php?number=${num.number}" class="pill">${num.number}</a>
          `).join('')}
        </div>
      `;
    };
  
    const fetchAndRender = async (tabId) => {
      try {
        const res = await fetch(endpoints[tabId]);
        const json = await res.json();
        if (tabId === 'mostWanted') {
          tabContent.innerHTML = renderTable(json.numbers);
        } else {
          tabContent.innerHTML = renderPills(json.numbers);
        }
      } catch (error) {
        tabContent.innerHTML = `<p>Error loading data.</p>`;
        console.error(error);
      }
    };
  
    // Setup tab click events
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelector('#tabs .active')?.classList.remove('active');
        tab.classList.add('active');
        const tabId = tab.dataset.tab;
        fetchAndRender(tabId);
      });
    });
  
    // Load first tab by default
    fetchAndRender('mostWanted');
  });
  