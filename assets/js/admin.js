document.addEventListener('DOMContentLoaded', function () {
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

    // Remove active class from all initially (to prevent duplicates)
    allSideMenu.forEach(item => item.parentElement.classList.remove('active'));

    // Get current URL path, accounting for possible query parameters or hash values
    let currentPath = window.location.pathname.split('/').pop(); // Get last segment of the path
    const queryStringAndHash = window.location.search + window.location.hash;
    if(queryStringAndHash) {
        // If there's a query string or hash, append it to match exactly
        currentPath += queryStringAndHash;
    }

    // Find and highlight the active link based on currentPath
    let isMatchFound = false;
    allSideMenu.forEach(item => {
        if (item.getAttribute('href') === currentPath || item.getAttribute('href') === window.location.href) {
            item.parentElement.classList.add('active');
            isMatchFound = true;
        }
    });

    // Fallback to highlighting the dashboard if no specific match is found
    if (!isMatchFound) {
        allSideMenu[0].parentElement.classList.add('active'); // Assuming the first link is Dashboard
    }




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})







const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

});
