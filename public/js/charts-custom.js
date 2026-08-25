$(document).ready(function () {

    'use strict';
    var brandPrimary;
    var brandPrimaryRgba;

    // Line Chart (CashFlow is now dynamically managed in index.blade.php)

    var SALEREPORTCHART = $('#sale-report-chart');
    if (SALEREPORTCHART.length > 0) {
        var recieved = SALEREPORTCHART.data('recieved');
        brandPrimary = SALEREPORTCHART.data('color');
        brandPrimaryRgba = SALEREPORTCHART.data('color_rgba');
        var soldqty = SALEREPORTCHART.data('soldqty');
        var datepoints = SALEREPORTCHART.data('datepoints');
        var label1 = SALEREPORTCHART.data('label1');
        var sale_report_chart = new Chart(SALEREPORTCHART, {
            type: 'line',
            data: {
                labels: datepoints,
                datasets: [
                    {
                        label: label1,
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: 'transparent',
                        borderColor: brandPrimary,
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 3,
                        pointBorderColor: brandPrimary,
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 5,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: brandPrimary,
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: soldqty,
                        spanGaps: false
                    },
                ]
            }
        });
    };



    var BESTSELLER    = $('#bestSeller');

    if (BESTSELLER.length > 0) {
        var sold_qty = BESTSELLER.data('sold_qty');
        brandPrimary = BESTSELLER.data('color');
        brandPrimaryRgba = BESTSELLER.data('color_rgba');
        var product_info = BESTSELLER.data('product');
        var bestSeller = new Chart(BESTSELLER, {
            type: 'bar',
            data: {
                labels: [ product_info[0], product_info[1], product_info[2]],
                datasets: [
                    {
                        label: "Sale Qty",
                        backgroundColor: [
                            brandPrimaryRgba,
                            brandPrimaryRgba,
                            brandPrimaryRgba,
                            brandPrimaryRgba
                        ],
                        borderColor: [
                            brandPrimary,
                            brandPrimary,
                            brandPrimary,
                            brandPrimary
                        ],
                        borderWidth: 1,
                        data: [ 
                                sold_qty[0], sold_qty[1],
                                sold_qty[2], 0],
                    }
                ]
            }
        });
    };

    var PIECHART = $('#pieChart');
    if (PIECHART.length > 0) {
        var brandPrimary = PIECHART.data('color');
        var brandPrimaryRgba = PIECHART.data('color_rgba');
        var price = PIECHART.data('price');
        var cost = PIECHART.data('cost');
        var label1 = PIECHART.data('label1');
        var label2 = PIECHART.data('label2');
        var label3 = PIECHART.data('label3');
        var myPieChart = new Chart(PIECHART, {
            type: 'pie',
            data: {
                labels: [
                    label1,
                    label2,
                    label3
                ],
                datasets: [
                    {
                        data: [price, cost, price-cost],
                        borderWidth: [1, 1, 1],
                        backgroundColor: [
                            brandPrimary,
                            "#ff8952",
                            "#858c85"
                        ],
                        hoverBackgroundColor: [
                            brandPrimaryRgba,
                            "rgba(255, 137, 82, 0.8)",
                            "rgb(133, 140, 133, 0.8)"
                        ],
                        hoverBorderWidth: [4, 4, 4],
                        hoverBorderColor: [
                            brandPrimaryRgba,
                            "rgba(255, 137, 82, 0.8)",
                            "rgb(133, 140, 133, 0.8)",
                            
                        ],
                    }]
            },
            options: {
                //rotation: -0.7*Math.PI
            }
        });
    }

    var TRANSACTIONCHART = $('#transactionChart');
    if (TRANSACTIONCHART.length > 0) {
        brandPrimary = TRANSACTIONCHART.data('color');
        brandPrimaryRgba = TRANSACTIONCHART.data('color_rgba');
        var revenue = TRANSACTIONCHART.data('revenue');
        var purchase = TRANSACTIONCHART.data('purchase');
        var expense = TRANSACTIONCHART.data('expense');
        var label1 = TRANSACTIONCHART.data('label1');
        var label2 = TRANSACTIONCHART.data('label2');
        var label3 = TRANSACTIONCHART.data('label3');
        var myTransactionChart = new Chart(TRANSACTIONCHART, {
            type: 'doughnut',
            data: {
                labels: [
                    label1,
                    label2,
                    label3
                ],
                datasets: [
                    {
                        data: [purchase, revenue, expense],
                        borderWidth: [1, 1, 1],
                        backgroundColor: [
                            brandPrimary,
                            "#ff8952",
                            "#858c85",
                            
                        ],
                        hoverBackgroundColor: [
                            brandPrimaryRgba,
                            "rgba(255, 137, 82, 0.8)",
                            "rgb(133, 140, 133, 0.8)",
                            
                        ],
                       hoverBorderWidth: [4, 4, 4],
                       hoverBorderColor: [
                            brandPrimaryRgba,
                            "rgba(255, 137, 82, 0.8)",
                            "rgb(133, 140, 133, 0.8)",
                            
                        ],
                    }]
            }
        });
    }
});
