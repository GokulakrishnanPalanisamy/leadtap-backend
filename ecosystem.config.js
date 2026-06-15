module.exports = {
    apps: [
        {
            name: "laravel-queue",
            script: "artisan",
            args: "queue:work",
            interpreter: "php"
        }
    ]
};
