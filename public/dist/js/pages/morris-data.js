// Dashboard 1 Morris-chart
$(function () {
    // Morris bar chart
        Morris.Bar({
            element: 'morris-bar-chart',
            data: [{
                y: '2006',
                a: 100,
                b: 90,
                c: 60
            },
            {
                y: '2007',
                a: 75,
                b: 65,
                c: 40
            }, {
                y: '2008',
                a: 50,
                b: 40,
                c: 30
            }, {
                y: '2009',
                a: 75,
                b: 65,
                c: 40
            }, {
                y: '2010',
                a: 50,
                b: 40,
                c: 30
            }, {
                y: '2011',
                a: 75,
                b: 65,
                c: 40
            }, {
                y: '2012',
                a: 100,
                b: 90,
                c: 40
            }],
            xkey: 'y',
            ykeys: ['a', 'b', 'c'],
            labels: ['A', 'B', 'C'],
            barColors:['#55ce63', '#2f3d4a', '#009efb'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });
     });
