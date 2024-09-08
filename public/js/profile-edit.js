const ratings = document.querySelectorAll(".rating");

ratings.forEach((rating) => {
    const stars = rating.getElementsByClassName("star");
    const ratingValue = rating.getAttribute('data-ratingValue');

    document.addEventListener("DOMContentLoaded", () => {
        for(i = 0; i < ratingValue; i++){
            stars[i].style.color = "#f0da61";
        }
    })
})