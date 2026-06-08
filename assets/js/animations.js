document.addEventListener("DOMContentLoaded", () => {

    const cards = document.querySelectorAll(".feature-card");

    cards.forEach((card,index)=>{

        card.style.opacity="0";

        setTimeout(()=>{

            card.style.transition="all .5s";
            card.style.opacity="1";
            card.style.transform="translateY(0)";

        }, index * 150);

    });

});