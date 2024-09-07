//forの条件式が<stars.lengthである場合、stars.lengthまで値が増加する処理が行われる
//forの条件式が<=iである場合、iまで値が増加する処理が行われる
const ratings = document.querySelectorAll(".rating"); //ratingsですべての投稿のratingクラスを取得

ratings.forEach((rating) => {
    var stars = rating.getElementsByClassName("star"); //foreachでratingとして1個ずつ取り出し、個々のrating内のstarクラスを取得
    var clicked = false;

    document.addEventListener("DOMContentLoaded", () => {
        for (let i = 0; i < stars.length; i++) {
            //該当のstars要素をマウスホバーした場合、そのstars要素まで黄色になる
            stars[i].addEventListener("mouseover", () => {
                if (!clicked) {
                    for (let j = 0; j <= i; j++) {
                        stars[j].style.color = "#f0da61";
                    }
                }
            });

            //該当のstars要素をマウスアウトした場合、全てのstars要素は灰色になる
            stars[i].addEventListener("mouseout", () => {
                if (!clicked) {
                    for (let j = 0; j < stars.length; j++) {
                        stars[j].style.color = "#a09a9a";
                    }
                }
            });

            stars[i].addEventListener("click", async () => {
                clicked = true; //if(!clicked)が効かなくなるので、mouseoverやmouseoutイベントが発火しなくなる
                const postId = rating.getAttribute("data-post-id");
                const ratingValue = i + 1;

                for (let j = 0; j <= i; j++) {
                    stars[j].style.color = "#f0da61";
                }
                for (let j = i + 1; j < stars.length; j++) {
                    stars[j].style.color = "#a09a9a";
                }

                try {
                    const response = await fetch("/rating", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({
                            rating: ratingValue,
                            postId: postId,
                        }),
                    }); //ここまでがfetchによるリクエストの設定

                    //レスポンスが成功していない場合にステータスコードをコンソールに表示
                    if (!response.ok) {
                        throw new Error(
                            `レスポンスステータス: ${response.status}`
                        );
                    }

                    //コントローラーからJSON形式で返却されたデータをawait response.json()でパースしてJavaScriptオブジェクトに変換
                    const data = await response.json();
                    console.log(data);
                    alert(data.message);
                } catch (error) {
                    console.log(error);
                } //ここまでがfetchによるレスポンスの設定
            });
        }
    });
});
