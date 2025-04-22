import Chart from "chart.js/auto";

// Bar Chart
// https://www.chartjs.org/docs/latest/charts/bar.html
const ctx = document.getElementById('lineChart');

//let backgroundColors = ['#ef476f', '#fb8500', '#ffb703', '#06d6a0', '#00b4d8', '#0077b6'];
//let borderColors = backgroundColors;
let backgroundColor = '#fb8500';
let borderColor = '#ef476f';

if (ctx) {
    let graphJSON = ctx.dataset.graph;
    if (graphJSON) {
        let graphData = JSON.parse(graphJSON);
        console.log(graphData['names']);
        console.log(graphData['title']);
        console.log(graphData['results']);
        let resultsTitle = graphData['title'];
        let resultsData = graphData['results'];
        if (graphData['percents']) {
            resultsData = graphData['percents'];
            resultsTitle = resultsTitle + '';
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: graphData['names'],
                datasets: [{
                    label: graphData['title'],
                    data: resultsData,
                    fill: false,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1,
                    tension: 0.2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}
