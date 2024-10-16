function showContent(tab) {
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));

    document.querySelectorAll('.content-container').forEach(container => {
        container.style.display = 'none';
    });

    const activeTab = document.querySelector(`.tab[onclick="showContent('${tab}')"]`);
    activeTab.classList.add('active');

    document.getElementById(`${tab}-content`).style.display = 'block';
}