@props([
    'id' => 'adminSearch',
    'placeholder' => 'Search...',
    'tableId' => null,
    'listId' => null, // For list-based views (like notifications)
    'searchFields' => [] // Array of data attributes to search in (e.g., ['name', 'email'])
])

<div class="search-wrap">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="{{ $id }}" placeholder="{{ $placeholder }}" autocomplete="off">
    @if(isset($slot) && $slot->isNotEmpty())
        <div class="search-actions">
            {{ $slot }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('{{ $id }}');
    const tableId = '{{ $tableId ?? "" }}';
    const listId = '{{ $listId ?? "" }}';
    const searchFields = @json($searchFields);
    
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        
        // If listId is provided, search within that list (for list-based views)
        if (listId) {
            const list = document.getElementById(listId);
            if (!list) return;
            
            const items = list.querySelectorAll('.list-item, [class*="list-item"]');
            
            items.forEach(item => {
                let matches = false;
                
                // If searchFields are specified, search only those data attributes
                if (searchFields.length > 0) {
                    matches = searchFields.some(field => {
                        // Try both camelCase (dataset) and kebab-case (getAttribute)
                        let value = '';
                        const camelField = field.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
                        if (item.dataset[camelField] !== undefined) {
                            value = String(item.dataset[camelField]).toLowerCase();
                        } else if (item.dataset[field] !== undefined) {
                            value = String(item.dataset[field]).toLowerCase();
                        } else {
                            value = (item.getAttribute('data-' + field) || '').toLowerCase();
                        }
                        return value.includes(searchTerm);
                    });
                } else {
                    // Otherwise, search all data attributes and text content
                    const itemText = item.textContent.toLowerCase();
                    matches = itemText.includes(searchTerm);
                }
                
                // Also check if search term is empty (show all)
                if (searchTerm === '') {
                    matches = true;
                }
                
                item.style.display = matches ? '' : 'none';
            });
        }
        // If tableId is provided, search within that table
        else if (tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;
            
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                let matches = false;
                
                // If searchFields are specified, search only those data attributes
                if (searchFields.length > 0) {
                    matches = searchFields.some(field => {
                        // Try both camelCase (dataset) and kebab-case (getAttribute)
                        let value = '';
                        // Convert field name to camelCase for dataset access
                        const camelField = field.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
                        if (row.dataset[camelField] !== undefined) {
                            value = String(row.dataset[camelField]).toLowerCase();
                        } else if (row.dataset[field] !== undefined) {
                            value = String(row.dataset[field]).toLowerCase();
                        } else {
                            value = (row.getAttribute('data-' + field) || '').toLowerCase();
                        }
                        return value.includes(searchTerm);
                    });
                } else {
                    // Otherwise, search all data attributes and text content
                    const rowText = row.textContent.toLowerCase();
                    matches = rowText.includes(searchTerm);
                }
                
                // Also check if search term is empty (show all)
                if (searchTerm === '') {
                    matches = true;
                }
                
                row.style.display = matches ? '' : 'none';
            });
        } else {
            // Fallback: search in all tables on the page
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    let matches = false;
                    
                    if (searchFields.length > 0) {
                        matches = searchFields.some(field => {
                            // Try both camelCase (dataset) and kebab-case (getAttribute)
                            let value = '';
                            const camelField = field.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
                            if (row.dataset[camelField] !== undefined) {
                                value = String(row.dataset[camelField]).toLowerCase();
                            } else if (row.dataset[field] !== undefined) {
                                value = String(row.dataset[field]).toLowerCase();
                            } else {
                                value = (row.getAttribute('data-' + field) || '').toLowerCase();
                            }
                            return value.includes(searchTerm);
                        });
                    } else {
                        const rowText = row.textContent.toLowerCase();
                        matches = rowText.includes(searchTerm);
                    }
                    
                    if (searchTerm === '') {
                        matches = true;
                    }
                    
                    row.style.display = matches ? '' : 'none';
                });
            });
        }
    });
});
</script>

