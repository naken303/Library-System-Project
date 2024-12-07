let box = document.getElementById("fisrtSlide");
        function nextSlide() {
            if (box.style.marginLeft == "0%") {
                box.style.marginLeft = "-20%";
            } else if (box.style.marginLeft == "-20%") {
                box.style.marginLeft = "-40%";
            } else {
                box.style.marginLeft = "0%";
            }
        }
        function perSlide() {
            if (box.style.marginLeft == "0%") {
                box.style.marginLeft = "-40%";
            } else if (box.style.marginLeft == "-20%") {
                box.style.marginLeft = "0%";
            } else {
                box.style.marginLeft = "-20%";
            }
        }
        setInterval(nextSlide ,5500);