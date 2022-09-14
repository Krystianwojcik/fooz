/*
* Get 20 Books
* */

document.addEventListener("DOMContentLoaded", () => {
    const getJSONButton = document.querySelector(".js-get-json");

    const getResults = () => {
        axios.get("/wp-json/posts/v1/books").then((res) => {
            alert("Spójrz w console");
            console.log(res.data);
        });
    };

    getJSONButton.addEventListener("click", getResults);
});


