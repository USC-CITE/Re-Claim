document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll(".tab-content");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            const target = button.dataset.tab;

            // Hide all contents
            contents.forEach(section => {
                section.hidden = true;
            })

            // Remove active style from all buttons
            buttons.forEach(btn => {
                btn.classList.remove("secondary");
            })

            // Display selected item
            document.getElementById(target).hidden = false;

            // Hide active button
            button.classList.add("secondary");
        })
    })
    buttons[0].classList.add("secondary");
})