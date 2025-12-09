// Dashboard Charts - Pure JavaScript SVG

document.addEventListener('DOMContentLoaded', function() {
    // Bar Chart - Books Borrowed per Month
    const barChart = document.getElementById('barChart');
    if (barChart) {
        drawBarChart(barChart);
    }

    // Pie Chart - Books by Category
    const pieChart = document.getElementById('pieChart');
    if (pieChart) {
        drawPieChart(pieChart);
    }
});

function drawBarChart(svg) {
    const width = 320;
    const height = 180;
    const padding = { top: 20, right: 20, bottom: 40, left: 40 };
    const chartWidth = width - padding.left - padding.right;
    const chartHeight = height - padding.top - padding.bottom;

    // Get data from PHP or use defaults
    const months = [];
    const now = new Date();
    for (let i = 5; i >= 0; i--) {
        const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
        months.push(date.toLocaleString('default', { month: 'short' }));
    }
    let data = window.monthlyData || [45, 52, 48, 61, 55, 67];
    
    // Ensure data is an array
    if (!Array.isArray(data)) {
        data = [45, 52, 48, 61, 55, 67];
    }
    
    // Validate and sanitize data
    const validData = data.map(val => {
        const num = Number(val);
        return (isNaN(num) || num < 0) ? 0 : num;
    });
    
    // Ensure we have valid data
    if (validData.length === 0) {
        validData.push(0, 0, 0, 0, 0, 0);
    }
    
    const maxValue = Math.max(...validData, 1); // Ensure at least 1 to avoid division by zero
    const barWidth = validData.length > 0 ? Math.max(10, (chartWidth / validData.length - 5)) : 20;
    const scale = maxValue > 0 ? (chartHeight / maxValue) : 1;

    // Create SVG group
    const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    g.setAttribute('transform', `translate(${padding.left}, ${padding.top})`);

    // Draw bars
    validData.forEach((value, index) => {
        const numValue = Number(value) || 0;
        const barHeight = Math.max(0, Math.min(chartHeight, numValue * scale)); // Ensure within bounds
        const x = index * (barWidth + 5);
        const y = Math.max(0, Math.min(chartHeight, chartHeight - barHeight)); // Ensure within bounds

        // Bar
        const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rect.setAttribute('x', Math.max(0, x));
        rect.setAttribute('y', Math.max(0, y));
        rect.setAttribute('width', Math.max(1, barWidth));
        rect.setAttribute('height', Math.max(0, barHeight));
        rect.setAttribute('fill', '#2e7d32');
        rect.setAttribute('rx', 2);
        rect.classList.add('chart-bar');
        g.appendChild(rect);

        // Value label
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', x + barWidth / 2);
        text.setAttribute('y', Math.max(0, y - 5)); // Ensure non-negative
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('font-size', '10');
        text.setAttribute('fill', '#666');
        text.textContent = numValue || 0;
        g.appendChild(text);

        // Month label
        const monthText = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        monthText.setAttribute('x', x + barWidth / 2);
        monthText.setAttribute('y', chartHeight + 15);
        monthText.setAttribute('text-anchor', 'middle');
        monthText.setAttribute('font-size', '10');
        monthText.setAttribute('fill', '#666');
        monthText.textContent = months[index];
        g.appendChild(monthText);
    });

    // Y-axis
    const yAxis = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    yAxis.setAttribute('x1', 0);
    yAxis.setAttribute('y1', 0);
    yAxis.setAttribute('x2', 0);
    yAxis.setAttribute('y2', chartHeight);
    yAxis.setAttribute('stroke', '#ddd');
    yAxis.setAttribute('stroke-width', 1);
    g.appendChild(yAxis);

    // X-axis
    const xAxis = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    xAxis.setAttribute('x1', 0);
    xAxis.setAttribute('y1', chartHeight);
    xAxis.setAttribute('x2', chartWidth);
    xAxis.setAttribute('y2', chartHeight);
    xAxis.setAttribute('stroke', '#ddd');
    xAxis.setAttribute('stroke-width', 1);
    g.appendChild(xAxis);

    svg.appendChild(g);
}

function drawPieChart(svg) {
    const width = 220;
    const height = 180;
    const centerX = width / 2;
    const centerY = height / 2;
    const radius = 60;

    // Get data from PHP or use defaults
    const categoryData = window.categoryData || [
        { label: 'Fiction', value: 35 },
        { label: 'Non-Fiction', value: 25 },
        { label: 'Science', value: 20 },
        { label: 'History', value: 20 }
    ];

    // Color mapping
    const colors = {
        'Fiction': '#007bff',
        'Non-Fiction': '#28a745',
        'Science': '#ffc107',
        'Science Fiction': '#ffc107',
        'History': '#dc3545',
        'Fantasy': '#6f42c1',
        'Mystery': '#e83e8c',
        'Other': '#6c757d'
    };

    const data = categoryData.map(item => ({
        label: item.label,
        value: item.value,
        color: colors[item.label] || colors['Other']
    }));

    let currentAngle = -Math.PI / 2; // Start from top
    const total = data.reduce((sum, item) => {
        const val = Number(item.value) || 0;
        return sum + val;
    }, 0);

    // If no data, show a message
    if (total === 0 || data.length === 0) {
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', centerX);
        text.setAttribute('y', centerY);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('font-size', '12');
        text.setAttribute('fill', '#999');
        text.textContent = 'No data available';
        svg.appendChild(text);
        return;
    }

    data.forEach((item, index) => {
        const itemValue = Number(item.value) || 0;
        const sliceAngle = (itemValue / total) * 2 * Math.PI;
        const endAngle = currentAngle + sliceAngle;

        // Create path for pie slice
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        const x1 = centerX + radius * Math.cos(currentAngle);
        const y1 = centerY + radius * Math.sin(currentAngle);
        const x2 = centerX + radius * Math.cos(endAngle);
        const y2 = centerY + radius * Math.sin(endAngle);

        const largeArc = sliceAngle > Math.PI ? 1 : 0;

        const d = [
            `M ${centerX} ${centerY}`,
            `L ${x1} ${y1}`,
            `A ${radius} ${radius} 0 ${largeArc} 1 ${x2} ${y2}`,
            'Z'
        ].join(' ');

        path.setAttribute('d', d);
        path.setAttribute('fill', item.color);
        path.classList.add('chart-slice');
        svg.appendChild(path);

        // Label
        const labelAngle = currentAngle + sliceAngle / 2;
        const labelRadius = radius * 0.7;
        const labelX = centerX + labelRadius * Math.cos(labelAngle);
        const labelY = centerY + labelRadius * Math.sin(labelAngle);

        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', labelX);
        text.setAttribute('y', labelY);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('font-size', '9');
        text.setAttribute('fill', '#fff');
        text.setAttribute('font-weight', '600');
        const percentage = total > 0 ? Math.round((itemValue / total) * 100) : 0;
        text.textContent = percentage + '%';
        svg.appendChild(text);

        currentAngle = endAngle;
    });

    // Update legend
    const legend = document.getElementById('categoryLegend');
    if (legend) {
        legend.innerHTML = '';
        data.forEach(item => {
            const li = document.createElement('li');
            const span = document.createElement('span');
            span.className = 'lg';
            span.style.backgroundColor = item.color;
            li.appendChild(span);
            li.appendChild(document.createTextNode(item.label));
            legend.appendChild(li);
        });
    }
}

