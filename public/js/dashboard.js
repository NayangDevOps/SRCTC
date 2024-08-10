//News container code
let emojiCounts = {};
function fetchNews(isAdmin) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const newsData = JSON.parse(xhr.responseText);
                displayNews(newsData, isAdmin);
            } else {
                console.error('Error fetching news:', xhr.status);
            }
        }
    };
    xhr.open('GET', `${SiteURL}/fetch-news`);
    xhr.send();
}
document.addEventListener('DOMContentLoaded', function() {
    const userTypeElement = document.getElementById('user-type');
    let isAdmin = '';
    if (userTypeElement && userTypeElement.value.length > 0) {
        const userType = userTypeElement.value;
        isAdmin = userType == 10 || userType == 20;
    } 
    fetchNews(isAdmin);
});
function displayNews(newsData, isAdmin) {
    const newsContainer = document.getElementById('news-container');
    if (newsContainer) {
    newsContainer.innerHTML = '';
    const filteredNewsData = isAdmin ? newsData : newsData.filter(newsItem => newsItem.news_status == 1);
    const numToShow = isAdmin ? newsData.length : Math.min(5, newsData.length);
    for (let i = 0; i < numToShow; i++) {
        let inactiveCount = newsData.filter(newsItem => newsItem.news_status == 1).length;
        const newsItem = filteredNewsData[i];
        const newsElement = document.createElement('div');
        newsElement.classList.add('news-item');
        newsElement.innerHTML = `
            <h3>${newsItem.news_title}</h3>
            <img src="${newsItem.news_image}" alt="Image">
            <p>${newsItem.news_content}</p>
            <p>Date: ${newsItem.news_date}</p>
			${isAdmin && newsItem.news_status == 1 ? `<button class="remove-button" onclick="removeNews(${newsItem.id})"><i class="bi bi-eye-slash"></i></button>` : ''}
            ${isAdmin && newsItem.news_status == 0 ? `<button class="add-button" onclick="addNews(${newsItem.id}, ${inactiveCount})"><i class="bi bi-eye"></i></button>` : ''}
            ${isAdmin ? `<button class="delete-button" onclick="deleteNews(${newsItem.id})"><i class="bi bi-trash"></i></button>` : ''}
            <div class="emoji-selector emoji-counts" id="emoji-container-${newsItem.id}">
                <button type="button" onclick="selectEmoji('😍', ${newsItem.id})">😍</button>
                <span class="custom-span" id="emoji-count-${newsItem.id}-😍">${newsItem.news_lovely_counts || ""}</span>
                <button type="button" onclick="selectEmoji('😊', ${newsItem.id})">😊</button>
                <span class="custom-span" id="emoji-count-${newsItem.id}-😊">${newsItem.news_happy_counts || ""}</span>
                <button type="button" onclick="selectEmoji('😐', ${newsItem.id})">😐</button>
                <span class="custom-span" id="emoji-count-${newsItem.id}-😐">${newsItem.news_neutral_counts || ""}</span>
                <button type="button" onclick="selectEmoji('😕', ${newsItem.id})">😕</button>
                <span class="custom-span" id="emoji-count-${newsItem.id}-😕">${newsItem.news_sad_counts || ""}</span>
                <button type="button" onclick="selectEmoji('😠', ${newsItem.id})">😠</button>
                <span class="custom-span" id="emoji-count-${newsItem.id}-😠">${newsItem.news_angry_counts || ""}</span>
            </div>
        `;
        newsContainer.appendChild(newsElement);
    }
}
}
function removeNews(newsId) {
    if (confirm('Are you sure you want to remove this news from the news section?')) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    handleSessionMessage(JSON.parse(xhr.responseText));
                    fetchNews(getIsAdmin());
                } else {
                    console.error('Error updating news status:', xhr.status);
                }
            }
        };
        xhr.open('POST', `${SiteURL}/remove-news`);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`news_id=${newsId}`);
    }
}
function addNews(newsId, inactiveCount) {
    const maxNewsItems = 5;
    if (inactiveCount >= maxNewsItems) {
        alert("You can't add more than 5 news items to the dashboard.");
        return;
    }
    if (confirm('Are you sure you want to add this news to the news section?')) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    handleSessionMessage(JSON.parse(xhr.responseText));
                    fetchNews(getIsAdmin());
                } else {
                    console.error('Error updating news status:', xhr.status);
                }
            }
        };
        xhr.open('POST', `${SiteURL}/update_news_status`);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`add_news_id=${newsId}`);
    }
}
function deleteNews(newsId) {
    if (confirm('Are you sure you want to permanently delete this news?')) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    handleSessionMessage(JSON.parse(xhr.responseText));
                    fetchNews(getIsAdmin());
                } else {
                    console.error('Error deleting news:', xhr.status);
                }
            }
        };
        xhr.open('POST', `${SiteURL}/delete-news`);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`news_id=${newsId}`);
    }
}
function selectEmoji(emoji, newsId) {
    emojiCounts[newsId] = emojiCounts[newsId] || {};
    emojiCounts[newsId][emoji] = (emojiCounts[newsId][emoji] || 0) + 1;
    updateEmojiCounts(newsId, emoji);
}
function updateEmojiCounts(newsId, emoji) {
    const countElement = document.getElementById(`emoji-count-${newsId}-${emoji}`);
    if (countElement) {
        let count = parseInt(countElement.textContent) || 0;
        count++;
        countElement.textContent = count;
        countElement.style.display = count > 0 ? 'inline' : 'none';
        countElement.style.marginLeft = '-20px';
        countElement.style.fontWeight = '600';
        countElement.style.fontSize = '13px';
        updateCountsInDatabase(newsId, emoji, count);
    }
}
function updateCountsInDatabase(newsId, emoji, count) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
            }
        }
    };
    xhr.open('POST', `${SiteURL}/update_emoji_counts`);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({ newsId: newsId, emoji: emoji, count: count }));
}
function handleSessionMessage(response) {
    const successAlert = document.getElementById('success-alert');
    const errorAlert = document.getElementById('error-alert');
    const formField = document.getElementById('form-field');
    if (response.status == "success") {
        if (successAlert) {
            successAlert.textContent = response.message;
            successAlert.classList.add('success');
            successAlert.style.display = 'flex';            
            setTimeout(() => {
                successAlert.style.display = 'none';
                successAlert.classList.remove('success');
            }, 5000);
        }
    } else if (response.status == "error") {
        if (errorAlert) {
            errorAlert.textContent = response.message;
            errorAlert.classList.add('error');
            errorAlert.style.display = 'flex';
            setTimeout(() => {
                errorAlert.style.display = 'none';
                errorAlert.classList.remove('error');
            }, 5000);
        }
    }
}
function getIsAdmin() {
    const userTypeElement = document.getElementById('user-type');
    let isAdmin = false;
    if (userTypeElement) {
        const userType = userTypeElement.value;
        isAdmin = userType == 10 || userType == 20;
    } else {
        console.error('Error: user-type element not found');
    }
    return isAdmin;
}
function openAddNewsModal() {
    $('#addNewsModal').modal('show');
}
function add_new_news() {
    var formData = new FormData($('#newsForm')[0]);    
    $.ajax({
        url: 'add_news_method',
        method: 'POST',
        data: formData,
        processData: false, 
        contentType: false, 
        success: function(response) {
            console.log(response);
            if(response.status === 'success') {
				fetchNews(getIsAdmin());
                $('#addNewsModal').modal('hide');
            } else {
                alert(response.message || 'An error occurred while adding news.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('An error occurred while processing your request.');
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    var profileImage = document.getElementById('profileImage');
    var profileMenu = document.getElementById('profileMenu');  
    if (profileImage && profileMenu) {
      profileImage.addEventListener('click', function(event) {
        event.stopPropagation();
        if (profileMenu.style.display === 'none' || profileMenu.style.display === '') {
          profileMenu.style.display = 'block';
        } else {
          profileMenu.style.display = 'none';
        }
      });
      document.addEventListener('click', function() {
        profileMenu.style.display = 'none';
      });
    }
});
function ToggleLoading(bool, elem){
	if(bool){
		if(elem != null){
			var odd = 1;
			var set_for = '#'+elem;
		}else{
			var even = 2;
			var set_for = 'body';
		}
		if($("#home_page_on_load_toggleloading").attr("id")) {
			$(set_for).append('<div id="loader" class="loader-custom"><img src="'+BaseUrl+'public/img/ajex_loader.gif" /></div>');			
			if(set_for != 'body'){
				$('#loader img').css({"position": "absolute"});
			}else{
				$('#loader img').css({"position": "fixed"});
			}
		} else {
		if($('#loader').length == 0){
			$(set_for).append('<div id="loader" class="loader-custom"><img src="'+BaseUrl+'public/img/ajex_loader.gif" /></div>');			
			if(set_for != 'body'){
				$('#loader img').css({"position": "absolute"});
			}else{
				$('#loader img').css({"position": "fixed"});
			}
		}
	}
	}else{
		(elem != null) ? $('#' + elem).find('#loader').remove() : $('#loader').remove();
	}
} 