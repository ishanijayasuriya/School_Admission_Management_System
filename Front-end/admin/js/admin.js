document.addEventListener('DOMContentLoaded', function () {
    loadDashboardStats();
    initGradeChart();
    loadRecentActivities();
    simulateRealTimeUpdates(); // Optional if you want real-time simulation
});

// Load total/approved/pending/rejected application counts from backend
function loadDashboardStats() {
    fetch('../../backend/admin/get_dashboard_stats.php')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const data = result.data;
                document.querySelectorAll('.card')[0].querySelector('p').innerText = data.total.toLocaleString();
                document.querySelectorAll('.card')[1].querySelector('p').innerText = data.approved.toLocaleString();
                document.querySelectorAll('.card')[2].querySelector('p').innerText = data.pending.toLocaleString();
                document.querySelectorAll('.card')[3].querySelector('p').innerText = data.rejected.toLocaleString();
            } else {
                console.error('Failed to load dashboard stats:', result.error);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
}

// Chart showing dummy applications by grade (you can make it dynamic later)
function initGradeChart() {
    const ctx = document.getElementById('gradeChart').getContext('2d');
    const gradeData = {
        labels: ['Grade 1', 'Grade 2-11', 'Grade 6', 'Grade 12'],
        datasets: [{
            label: 'Applications by Grade',
            data: [120, 150, 100, 90], // You can replace these with real counts later
            backgroundColor: [
                'rgba(52, 152, 219, 0.7)',
                'rgba(46, 204, 113, 0.7)',
                'rgba(241, 196, 15, 0.7)',
                'rgba(231, 76, 60, 0.7)'
            ],
            borderColor: [
                'rgba(52, 152, 219, 1)',
                'rgba(46, 204, 113, 1)',
                'rgba(241, 196, 15, 1)',
                'rgba(231, 76, 60, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: gradeData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.parsed.y} applications`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Applications'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Grade Level'
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
}

// Dummy recent activity data (static for now)
function loadRecentActivities() {
    const activities = [
        {
            icon: 'fa-user-check',
            text: 'You approved application #GL2023-00456',
            time: '10 minutes ago'
        },
        {
            icon: 'fa-file-upload',
            text: 'New application received from John Doe',
            time: '1 hour ago'
        },
        {
            icon: 'fa-user-edit',
            text: 'Updated user profile for Jane Smith',
            time: '2 hours ago'
        },
        {
            icon: 'fa-file-alt',
            text: 'Document verified for application #GL2023-00432',
            time: '3 hours ago'
        },
        {
            icon: 'fa-user-times',
            text: 'Rejected application #GL2023-00389',
            time: '5 hours ago'
        }
    ];

    const activityList = document.querySelector('.activity-list');
    activityList.innerHTML = '';

    activities.forEach(activity => {
        const item = document.createElement('div');
        item.className = 'activity-item';
        item.innerHTML = `
            <div class="activity-icon">
                <i class="fas ${activity.icon}"></i>
            </div>
            <div class="activity-details">
                <p>${activity.text}</p>
                <span class="activity-time">${activity.time}</span>
            </div>`;
        activityList.appendChild(item);
    });
}

// Optional simulation of real-time stat change (just for fun)
function simulateRealTimeUpdates() {
    setInterval(() => {
        const cards = document.querySelectorAll('.card');
        const randomCard = cards[Math.floor(Math.random() * cards.length)];
        const valueElement = randomCard.querySelector('p');
        const trendElement = randomCard.querySelector('.trend');

        let currentValue = parseInt(valueElement.textContent.replace(/,/g, ''));
        const changePercent = (Math.random() > 0.5 ? 1 : -1) * (1 + Math.floor(Math.random() * 5));
        const changeValue = Math.round(currentValue * (changePercent / 100));
        const newValue = currentValue + changeValue;

        valueElement.textContent = newValue.toLocaleString();

        if (changePercent > 0) {
            trendElement.innerHTML = `+${changePercent}% from last hour <i class="fas fa-arrow-up"></i>`;
            trendElement.className = 'trend up';
        } else {
            trendElement.innerHTML = `${changePercent}% from last hour <i class="fas fa-arrow-down"></i>`;
            trendElement.className = 'trend down';
        }

    }, 10000); // Every 10 seconds
}
