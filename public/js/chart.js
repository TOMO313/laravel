const chart = document.getElementById('chart');
const data = [
    { year:2020, count:10, yen:100 },
    { year:2021, count:20, yen:200 },
    { year:2022, count:30, yen:300 },
    { year:2023, count:40, yen:400 },
];

new Chart(chart, {
    data: {
        labels: data.map(row => row.year), //要素
        datasets: [{
            type: 'bar',
            label: '来客人数', //何のグラフか
            data: data.map(row => row.count), //値
            borderWidth: 1 //線の幅
        }, {
            type: 'line',
            label: '売上高', 
            data: data.map(row => row.yen),
            borderWidth: 1 
        }],
    },
    options: {
        scales: { //グラフの軸
        y: { //Y軸
            beginAtZero: true //最小値が0から始まる
        }
        }
    }
});