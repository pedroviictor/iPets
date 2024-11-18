const calendar = document.getElementById('calendar');
const today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
const currentDay = today.getDate();

let selectedDays = [];

const horariosPadrao = ['10:00', '14:00', '18:00'];

function createCalendar(month, year) {
    const monthNames = ['Jan. de', 'Fev. de', 'Mar. de', 'Abr. de', 'Mai. de', 'Jun. de', 'Jul. de', 'Ago. de', 'Set. de', 'Out. de', 'Nov. de', 'Dez. de'];
    const totalDays = new Date(year, month + 1, 0).getDate();
    const firstDayIndex = new Date(year, month, 1).getDay();

    let html = `<div id="calendar-header">`;
    html += `<h4 id="month-year">${monthNames[month]} ${year}</h4>`;
    html += `</div>`;
    html += '<table>';
    html += '<tr><th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sab</th></tr>';

    let day = 1;
    for (let i = 0; i < 6; i++) {
        html += '<tr>';
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDayIndex) {
                html += '<td></td>';
            } else if (day > totalDays) {
                break;
            } else {
                const classNames = [];

                if (day === currentDay && month === today.getMonth() && year === today.getFullYear()) {
                    classNames.push('current-day');
                }

                if (selectedDays.includes(`${year}-${month + 1}-${day}`)) {
                    classNames.push('selected-day');
                }
                html += `<td class="${classNames.join(' ')}" data-date="${year}-${month + 1}-${day}"><button>${day}</button></td>`;
                day++;
            }
        }
        html += '</tr>';
    }
    html += '</table>';

    calendar.innerHTML = html;

    document.querySelectorAll('#calendar td[data-date]').forEach(dayElement => {
        dayElement.addEventListener('click', function () {
            const date = this.getAttribute('data-date');

            selectedDays = [date];
            document.querySelectorAll('#calendar td').forEach(td => td.classList.remove('selected-day'));
            this.classList.add('selected-day');

            updateHorarios(date);
        });
    });
}

function updateHorarios(date) {
    const horariosContainer = document.getElementById('horarios-lista');
    const dataSelecionada = document.getElementById('data-selecionada');

    const [ano, mes, dia] = date.split('-');
    const dataObj = new Date(ano, mes - 1, dia);

    const diasSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];

    const diaSemana = diasSemana[dataObj.getDay()];
    const dataFormatada = `Dia ${dia}/${mes} • ${diaSemana}`;

    dataSelecionada.textContent = dataFormatada;

    fetch(`calendariovendedor.php?date=${date}`)
        .then(response => response.json())
        .then(data => {
            horariosContainer.innerHTML = '';
            data.forEach(hora => {
                const li = document.createElement('li');
                li.textContent = hora;
                horariosContainer.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Erro ao consultar os agendamentos:', error);
        });

    const baseUrl = window.location.origin + window.location.pathname;
    const newUrl = `${baseUrl}?date=${ano}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`;
    window.history.pushState({}, '', newUrl);
}

createCalendar(currentMonth, currentYear);