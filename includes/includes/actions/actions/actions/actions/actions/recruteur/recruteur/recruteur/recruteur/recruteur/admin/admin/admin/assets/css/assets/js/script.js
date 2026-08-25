document.addEventListener('DOMContentLoaded', function () {

    // ---- Confirmation avant suppression ----
    document.querySelectorAll('.confirm-delete').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm('Confirmez-vous la suppression ? Cette action est irréversible.')) {
                e.preventDefault();
            }
        });
    });

    // ---- Barre de progression du quiz ----
    var radios = document.querySelectorAll('.quiz-options input[type="radio"]');
    var totalQuestions = document.querySelectorAll('.quiz-question').length;
    var progressBar = document.getElementById('quizProgressBar');

    function updateProgress() {
        if (!progressBar || totalQuestions === 0) return;
        var answered = {};
        document.querySelectorAll('.quiz-options input[type="radio"]:checked').forEach(function (r) {
            answered[r.name] = true;
        });
        var count = Object.keys(answered).length;
        var pct = Math.round((count / totalQuestions) * 100);
        progressBar.style.width = pct + '%';
    }

    radios.forEach(function (r) {
        r.addEventListener('change', updateProgress);
    });
    updateProgress();

    // ---- Alerte auto-masquée ----
    document.querySelectorAll('.alert[data-autohide]').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 400);
        }, 4000);
    });
});
