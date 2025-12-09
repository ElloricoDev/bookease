// Reports Charts - Pure JavaScript SVG

document.addEventListener('DOMContentLoaded', function() {
    // Get data from PHP (passed via data attributes or inline script)
    const monthlyBorrowings = window.monthlyBorrowings || [120, 135, 145, 130, 150, 165, 180];
    const monthlyOverdue = window.monthlyOverdue || [5, 8, 12, 7, 10, 15, 9];
    const monthlyActiveUsers = window.monthlyActiveUsers || [45, 52, 48, 61, 55, 67, 72];
    const monthlyRevenue = window.monthlyRevenue || [5000, 5500, 6000, 5800, 6200, 6500, 7000];
    const monthLabels = window.monthLabels || [];

    // Books Borrowed Reports Chart
    const chart1 = document.getElementById('reportsChart1');
    if (chart1) {
        drawLineChart(chart1, monthlyBorrowings, 'Books Borrowed');
    }

    // Overdue Books Reports Chart
    const chart2 = document.getElementById('reportsChart2');
    if (chart2) {
        drawBarChart(chart2, monthlyOverdue, 'Overdue Books', '#dc3545');
    }

    // User Activity Reports Chart
    const chart3 = document.getElementById('reportsChart3');
    if (chart3) {
        drawBarChart(chart3, monthlyActiveUsers, 'Active Users', '#17a2b8');
    }

    // Revenue Trend Chart
    const chart4 = document.getElementById('reportsChart4');
    if (chart4) {
        drawLineChart(chart4, monthlyRevenue, 'Revenue', '#28a745');
    }
});

function drawLineChart(svg, data, title, color = '#2e7d32') {
    // Clear previous content
    svg.innerHTML = '';
    
    const width = 320;
    const height = 160;
    const padding = { top: 20, right: 20, bottom: 30, left: 40 };
    const chartWidth = width - padding.left - padding.right;
    const chartHeight = height - padding.top - padding.bottom;

    if (!data || data.length === 0) {
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', width / 2);
        text.setAttribute('y', height / 2);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('fill', '#999');
        text.textContent = 'No data available';
        svg.appendChild(text);
        return;
    }

    const maxValue = Math.max(...data);
    const minValue = Math.min(...data);
    const range = maxValue - minValue || 1;
    const scale = chartHeight / range;
    const stepX = data.length > 1 ? chartWidth / (data.length - 1) : 0;

    const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    g.setAttribute('transform', `translate(${padding.left}, ${padding.top})`);

    // Draw line
    let pathData = '';
    data.forEach((value, index) => {
        const x = index * stepX;
        const y = chartHeight - (value - minValue) * scale;
        pathData += (index === 0 ? 'M' : 'L') + ` ${x} ${y}`;
    });

    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path.setAttribute('d', pathData);
    path.setAttribute('fill', 'none');
    path.setAttribute('stroke', color);
    path.setAttribute('stroke-width', '2');
    path.classList.add('chart-line');
    g.appendChild(path);

    // Draw points
    data.forEach((value, index) => {
        const x = index * stepX;
        const y = chartHeight - (value - minValue) * scale;

        const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
        circle.setAttribute('cx', x);
        circle.setAttribute('cy', y);
        circle.setAttribute('r', 3);
        circle.setAttribute('fill', color);
        circle.classList.add('chart-point');
        g.appendChild(circle);

        // Value label - format numbers appropriately
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', x);
        text.setAttribute('y', y - 8);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('font-size', '9');
        text.setAttribute('fill', '#666');
        text.textContent = typeof value === 'number' && value > 1000 ? (value / 1000).toFixed(1) + 'k' : value;
        g.appendChild(text);
    });

    // Axes
    const yAxis = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    yAxis.setAttribute('x1', 0);
    yAxis.setAttribute('y1', 0);
    yAxis.setAttribute('x2', 0);
    yAxis.setAttribute('y2', chartHeight);
    yAxis.setAttribute('stroke', '#ddd');
    yAxis.setAttribute('stroke-width', 1);
    g.appendChild(yAxis);

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

function drawBarChart(svg, data, title, color = '#2e7d32') {
    const width = 320;
    const height = 160;
    const padding = { top: 20, right: 20, bottom: 30, left: 40 };
    const chartWidth = width - padding.left - padding.right;
    const chartHeight = height - padding.top - padding.bottom;

    const maxValue = Math.max(...data);
    const barWidth = chartWidth / data.length - 3;
    const scale = chartHeight / maxValue;

    const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    g.setAttribute('transform', `translate(${padding.left}, ${padding.top})`);

    data.forEach((value, index) => {
        const barHeight = value * scale;
        const x = index * (barWidth + 3);
        const y = chartHeight - barHeight;

        const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rect.setAttribute('x', x);
        rect.setAttribute('y', y);
        rect.setAttribute('width', barWidth);
        rect.setAttribute('height', barHeight);
        rect.setAttribute('fill', color);
        rect.setAttribute('rx', 2);
        rect.classList.add('chart-bar');
        g.appendChild(rect);

        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', x + barWidth / 2);
        text.setAttribute('y', y - 5);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('font-size', '9');
        text.setAttribute('fill', '#666');
        text.textContent = value;
        g.appendChild(text);
    });

    // Axes
    const yAxis = document.createElementNS('http://www.w3.org/2000/svg', 'line');
    yAxis.setAttribute('x1', 0);
    yAxis.setAttribute('y1', 0);
    yAxis.setAttribute('x2', 0);
    yAxis.setAttribute('y2', chartHeight);
    yAxis.setAttribute('stroke', '#ddd');
    yAxis.setAttribute('stroke-width', 1);
    g.appendChild(yAxis);

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

