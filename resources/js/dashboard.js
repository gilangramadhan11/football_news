import Chart from 'chart.js/auto';

console.log("Dashboard JS Loaded");

const ctx = document.getElementById('articleChart');

console.log("Canvas:", ctx);

if (ctx) {
    console.log("Labels:", window.chartLabels);
    console.log("Data:", window.chartData);

    try {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: window.chartLabels,
                datasets: [{
                    label: 'Jumlah Artikel',
                    data: window.chartData,
                    borderColor: '#2563eb',
                    backgroundColor: '#93c5fd',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: false
                }]
            }
        });

        console.log("Chart berhasil dibuat");
    } catch (error) {
        console.error("Chart Error:", error);
    }
}

const statusCanvas = document.getElementById('statusChart');

if (statusCanvas) {

    const existing = Chart.getChart(statusCanvas);

    if (existing) existing.destroy();

    new Chart(statusCanvas, {

        type: 'doughnut',

        data: {

            labels: window.statusLabels,

            datasets: [{

                data: window.statusData,

                backgroundColor: [

                    '#22c55e', // Published

                    '#facc15'  // Draft

                ]

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    position: 'bottom'

                }

            }

        }

    });

}