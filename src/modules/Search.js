class Search {

    // 1. Describe and create/initiate our object
    constructor() {
        this.nakladka = document.querySelector(".search-overlay");
        this.searchIcon = document.querySelector(".js-search-trigger");
        this.searchCloseBtn = document.querySelector(".search-overlay__close");
        this.inputSearch = document.querySelector(".search-term");
        this.resultsDiv = document.querySelector("#search-overlay__results");

        this.events();
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.previousValue;
        this.typingTimer;
    }

    // 2. Events
    events() {
        this.searchIcon.addEventListener("click", this.openOverlay.bind(this));
        this.searchCloseBtn.addEventListener("click", this.closeOverlay.bind(this));
        document.addEventListener("keyup", this.keyPressDispatcher.bind(this));
        this.inputSearch.addEventListener("keyup", this.typingLogic.bind(this));
    }

    // 3. Methods (function, action...)
    typingLogic() {
        if (this.previousValue != this.inputSearch.value) {
            clearTimeout(this.typingTimer);
            if (this.inputSearch.value.length >= 3) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 1000);
            } else {
                this.resultsDiv.innerHTML = "Wpisz więcej...";
                this.isSpinnerVisible = false;
            }
        }

        this.previousValue = this.inputSearch.value;
    }

    getResults() {
        this.isSpinnerVisible = false;
        this.resultsDiv.innerHTML = "Imagine results";
    }

    keyPressDispatcher(ClickedBtn) {
        if (ClickedBtn.key == "Escape" && this.isOverlayOpen)
            this.closeOverlay();
    }

    openOverlay() {
        this.nakladka.classList.add("search-overlay--active");
        document.body.classList.add("body-no-scroll");
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.nakladka.classList.remove("search-overlay--active");
        document.body.classList.remove("body-no-scroll");
        this.isOverlayOpen = false;
    }
}

export default Search;