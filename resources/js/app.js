import "./bootstrap";

document.querySelector(".menu-toggle")?.addEventListener("click", () => {
    document.querySelector(".portal-nav")?.classList.toggle("open");
});

document.querySelector(".filter-toggle")?.addEventListener("click", () => {
    document.querySelector(".filters")?.classList.toggle("open");
});

