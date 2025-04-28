$(document).ready(function () {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    );
    const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );
});

document.addEventListener('DOMContentLoaded', function () {
    const boardColorSelect = document.getElementById('boardColor');
    const colorMap = {
        red: '#ffcccc',
        blue: '#cce5ff',
        green: '#d4edda',
        yellow: '#fff3cd',
        purple: '#e2ccff',
        orange: '#ffd8b3',
    };

    boardColorSelect.addEventListener('change', function () {
        const selectedColorHex = colorMap[this.value] || '#ffffff';
        this.style.backgroundColor = selectedColorHex;
    });

    const initialColorName = boardColorSelect.value;
    boardColorSelect.style.backgroundColor =
        colorMap[initialColorName] || '#ffffff';
});
