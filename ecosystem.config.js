module.exports = {
  apps : [{
    name: 'LaravelApp',
    script: 'artisan',
    args: 'serve --host=0.0.0.0 --port=8000',
    interpreter: 'php',
    watch: true
  }]
};
