class Search {

    // 1. Describe and create/initiate our object
    constructor() {
        this.addSearchHTML();
        this.nakladka = document.querySelector(".search-overlay");
        this.searchIcon = document.querySelectorAll(".js-search-trigger");
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
        this.searchIcon.forEach(e => {
            e.addEventListener("click", this.openOverlay.bind(this));
        });
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
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            } else {
                this.resultsDiv.innerHTML = "Wpisz więcej...";
                this.isSpinnerVisible = false;
            }
        }

        this.previousValue = this.inputSearch.value;
    }

    getResults() {
        fetch(`${universityData.root_url}/wp-json/university/v1/search?term=${this.inputSearch.value}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            this.resultsDiv.innerHTML = `
            <div class="row">
                <div class="one-third">
                    <h2 class="search-overlay__section-title">General Information</h2>
                    ${data.generalInfo.length > 0 ? `
                    <ul class="link-list min-list">
                    ${data.generalInfo.map(e => `<li><a href="${e.permalink}">${e.title}</a> ${e.postType == 'post' ? `by ${e.authorName}</li>` : ''}`).join("")}
                    </ul>
                    ` : `<p>Brak wpisów dla tego zapytania. <a href="${universityData.root_url}/blog">Zobacz wszystkie wpisy</a></p>`}
                        
                </div>
                <div class="one-third">
                    <h2 class="search-overlay__section-title">Programs</h2>
                    ${data.programs.length > 0 ? `
                    <ul class="link-list min-list">
                    ${data.programs.map(e => `<li><a href="${e.permalink}">${e.title}</a></li>`).join("")}
                    </ul>
                    ` : `<p>Brak programów dla tego zapytania. <a href="${universityData.root_url}/programs">Zobacz wszystkie programy</a></p>`}  

                    <h2 class="search-overlay__section-title">Professors</h2>
                    ${data.professors.length > 0 ? `
                        <ul class="link-list min-list">
                        ${data.professors.map(e => `<li class="professor-card__list-item">
                            <a href="${e.permalink}" class="professor-card">
                                <img class="professor-card__image" src="${e.thumbnail}" alt="">
                                <span class="professor-card__name">${e.title}</span>
                            </a>
                        </li>`).join("")}
                        </ul>` : `<p>Brak profesorów dla tego zapytania. <a href="${universityData.root_url}/professors">Zobacz wszystkich profesorów</a></p>`}  
                </div>
                <div class="one-third">
                    <h2 class="search-overlay__section-title">Campuses</h2>
                    ${data.campuses.length > 0 ? `
                        <ul class="link-list min-list">
                        ${data.campuses.map(e => `<li><a href="${e.permalink}">${e.title}</a> ${e.postType == 'post' ? `by ${e.authorName}</li>` : ''}`).join("")}
                        </ul>
                        ` : `<p>Brak kampusów dla tego zapytania. <a href="${universityData.root_url}/campuses">Zobacz wszystkie kampusy</a></p>`}  

                    <h2 class="search-overlay__section-title">Events</h2>
                    ${data.events.length > 0 ? `
                        <ul class="min-list">
                        ${data.events.map(e => `
                        <div class="event-summary">
            <a class="event-summary__date t-center" href="${e.permalink}">
              <span class="event-summary__month">${e.month}</span>
              <span class="event-summary__day">${e.day}</span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="${e.permalink}">${e.title}</a></h5>
              <p>${e.excerpt} <a href="${e.permalink}" class="nu gray">Learn more</a></p>
            </div>
            </div>
                        `).join("")}
                        </ul>
                        ` : `<p>Brak wydarzeń dla tego zapytania. <a href="${universityData.root_url}/events">Zobacz wszystkie wydarzenia</a></p>`}   
                </div>
            </div>`;
        });
        

        this.isSpinnerVisible = false;

        // try {
        //     const endpoints = ["posts", "pages", "event", "professor", "program", "campus"];
        //     let results = [];
        //     for (const endpoint of endpoints) {
        //         let response = await fetch(`${universityData.root_url}/wp-json/wp/v2/${endpoint}?search=${this.inputSearch.value}`);
        //         const resultsjson = await response.json();
        //         results = results.concat(resultsjson);
        //     }

        //     // const posts = await fetch(universityData.root_url + `/wp-json/wp/v2/posts?search=${this.inputSearch.value}`);
        //     // const postsjson = await posts.json();
        //     // const pages = await fetch(universityData.root_url + `/wp-json/wp/v2/pages?search=${this.inputSearch.value}`);
        //     // const pagesjson = await pages.json();
        //     // const event = await fetch(universityData.root_url + `/wp-json/wp/v2/event?search=${this.inputSearch.value}`);
        //     // const eventjason = await event.json();
        //     // const professor = await fetch(universityData.root_url + `/wp-json/wp/v2/professor?search=${this.inputSearch.value}`);
        //     // const professorjason = await professor.json();
        //     // const program = await fetch(universityData.root_url + `/wp-json/wp/v2/program?search=${this.inputSearch.value}`);
        //     // const programjson = await program.json();
        //     // const campus = await fetch(universityData.root_url + `/wp-json/wp/v2/campus?search=${this.inputSearch.value}`);
        //     // const campusejson = await campus.json();

        //     // let results = postsjson.concat(pagesjson).concat(eventjason).concat(professorjason).concat(programjson).concat(campusejson);
        // //     this.resultsDiv.innerHTML = `
        // //             <h2 class="search-overlay__section-title">Search Results</h2>
        // //             ${results.length > 0 ? `
        // //                 <ul class="link-list min-list">
        // //                 ${results.map(e => `<li><a href="${e.link}">${e.title.rendered}</a> ${e.type == 'post' ? `by ${e.authorName}</li>` : ''}`).join("")}
        // //                 </ul>
        // //                 ` : "<p>Brak wyników dla tego zapytania.</p>"}
        // //                 `;

        // //     this.isSpinnerVisible = false;
        // // } catch (error) {
        // //     this.resultsDiv.innerHTML = error.message;
        // // }
    }

    keyPressDispatcher(ClickedBtn) {
        if (ClickedBtn.key == "Escape" && this.isOverlayOpen)
            this.closeOverlay();
    }

    openOverlay() {
        this.nakladka.classList.add("search-overlay--active");
        document.body.classList.add("body-no-scroll");
        setTimeout(() => this.inputSearch.focus(), 301);
        this.isOverlayOpen = true;
        event.preventDefault();
    }

    closeOverlay() {
        this.nakladka.classList.remove("search-overlay--active");
        document.body.classList.remove("body-no-scroll");
        this.isOverlayOpen = false;
        this.inputSearch.value = '';
        this.resultsDiv.innerHTML = '';
    }

    addSearchHTML() {
        document.querySelector("body").innerHTML += `
            <div class="search-overlay">
          <div class="search-overlay__top">
            <div class="container">
              <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
              <input type="text" class="search-term" placeholder="What are you looking for?">
              <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
          </div>

          <div class="container">
            <div id="search-overlay__results"></div>
          </div>

       </div>
            `;
    }
}

export default Search;
