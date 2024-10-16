const calendar = document.getElementById('calendar');
const today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
const currentDay = today.getDate();

let selectedDays = [];

function createCalendar(month, year) {
    const monthNames = ['Jan. de', 'Fev. de', 'Mar. de', 'Abr. de', 'Mai. de', 'Jun. de', 'Jul. de', 'Ago. de', 'Set. de', 'Out. de', 'Nov. de', 'Dez. de'];
    const totalDays = new Date(year, month + 1, 0).getDate();
    const firstDayIndex = new Date(year, month, 1).getDay();

    let html = `<div id="calendar-header">`;
    html += `<h4 id="month-year">${monthNames[month]} ${year}</h4>`;
    html += `<button id="prev-month">&lt;</button>`;
    html += `<button id="next-month">&gt;</button>`;
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
                html += `<td class="${classNames.join(' ')}" data-date="${year}-${month + 1}-${day}">${day}</td>`;
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
            if (selectedDays.includes(date)) {
                selectedDays = selectedDays.filter(d => d !== date);
                this.classList.remove('selected-day');
            } else if (selectedDays.length < 3) {
                selectedDays.push(date);
                this.classList.add('selected-day');
            }
            console.log('Dias selecionados: ', selectedDays); // Dias selecionados
        });
    });

    document.getElementById('prev-month').addEventListener('click', function () {
        if (currentMonth === 0) {
            currentMonth = 11;
            currentYear--;
        } else {
            currentMonth--;
        }
        createCalendar(currentMonth, currentYear);
    });

    document.getElementById('next-month').addEventListener('click', function () {
        if (currentMonth === 11) {
            currentMonth = 0;
            currentYear++;
        } else {
            currentMonth++;
        }
        createCalendar(currentMonth, currentYear);
    });
}

createCalendar(currentMonth, currentYear);