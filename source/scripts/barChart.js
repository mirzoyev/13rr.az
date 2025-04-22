import Chart from "chart.js/auto";

// Bar Chart
// https://www.chartjs.org/docs/latest/charts/bar.html
const ctx = document.getElementById('barChart');

let backgroundColors = ['#ef476f', '#fb8500', '#ffb703', '#06d6a0', '#00b4d8', '#0077b6'];
//let borderColors = backgroundColors;

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
            type: 'bar',
            data: {
                labels: graphData['names'],
                datasets: [{
                    label: graphData['title'],
                    data: resultsData,
                    backgroundColor: backgroundColors,
                    //borderColor: borderColors,
                    borderWidth: 1
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

if (ctx && false) {
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            datasets: [{
                label: ['Label'],
                data: [4, 2, 5, 3, 6, 4, 1, 2, 3, 2],
                backgroundColor: backgroundColors,
                borderWidth: 1
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
