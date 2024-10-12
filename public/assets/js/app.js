const app = new Vue({
    el: '#app',
    data() {
        return {
            title: window.appData.title,
            message: window.appData.message,
            user: window.appData.user
        };
    },
    template: `
        <div>
            <h2>{{ title }}</h2>
            <p>{{ message }}</p>
            <p>Logged in as: {{ user }}</p>
        </div>
    `
});
