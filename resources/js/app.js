require('./bootstrap');

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'
Alpine.plugin(intersect)

window.Alpine = Alpine;
queueMicrotask(() => {
    Alpine.start()
});

window.articleComponent = articleComponent()

function articleComponent() {
    return {
        articles: [],
        page: 1,
        loading: false,
        loadMore(src) {
            this.loading = true
            axios.post(src, {page: this.page})
                .then((response) => {
                    this.articles.push(...response.data.posts);
                    this.page = response.data.current + 1;
                    this.loading = false
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}

window.addEventListener('DOMContentLoaded', () => {
    let scrollPos = 0;
    const mainNav = document.getElementById('mainNav');
    const headerHeight = mainNav.clientHeight;
    window.addEventListener('scroll', function() {
        const currentTop = document.body.getBoundingClientRect().top * -1;
        if ( currentTop < scrollPos) {
            // Scrolling Up
            if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-visible');
            } else {
                console.log(123);
                mainNav.classList.remove('is-visible', 'is-fixed');
            }
        } else {
            // Scrolling Down
            mainNav.classList.remove(['is-visible']);
            if (currentTop > headerHeight && !mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-fixed');
            }
        }
        scrollPos = currentTop;
    });
})

