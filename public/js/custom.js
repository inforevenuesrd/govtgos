function updateTime() {
            var now = new Date();
            var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var dayName = days[now.getDay()]; // Get the current day name

            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12; // Convert to 12-hour format

            var timeString = dayName + ', ' + hours + ':' + minutes + ':' + seconds + ' ' + ampm;
            document.getElementById("live-time").textContent = timeString;
        }

        setInterval(updateTime, 1000); // Update every second
        updateTime(); // Initial call to display immediately

        