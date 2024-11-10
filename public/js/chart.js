const chart = document.getElementById("chart");
const data = [{ number: 10 }, { number: 20 }, { number: 30 }, { number: 40 }];

var Chart = new Chart(chart, {
    data: {
        labels: dataYear, //横軸の値。dataYearの中身は[2020, 2021, 2022, 2023]という配列。
        datasets: [
            {
                type: "bar",
                label: "売上高",
                data: dataAmount, //縦軸の値。dataAmountの中身は[200, 300, 400, 500]という配列。
                borderWidth: 1, //線の幅
            },
            {
                type: "line",
                label: "客数",
                data: data.map((data) => data.number), //map()は配列の各要素({number: 10}など)に対して新しい配列[10, 20, 30, 40]を返す
                borderWidth: 1, //線の幅
            },
        ],
    },
    options: {
        scales: {
            //グラフの軸
            y: {
                //Y軸
                beginAtZero: true, //最小値が0から始まる
            },
        },
    },
});
