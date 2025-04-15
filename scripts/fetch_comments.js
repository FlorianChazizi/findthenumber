document.addEventListener("DOMContentLoaded", () => {
    const numberId = "<?php echo $data['id']; ?>"; // PHP passes it to JS
    const commentsContainer = document.getElementById("commentsContainer");

    fetch(`backend/fetch_comments.php?id=${numberId}`)
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                commentsContainer.innerHTML = data.map(comment => `
                    <div class="comment-card">
                        <p><strong>Rank:</strong> ${comment.rank ?? 'Not specified'}</p>
                        <p>${comment.comment}</p>
                        <small>${new Date(comment.created_at).toLocaleString()}</small>
                    </div>
                `).join('');
            } else {
                commentsContainer.innerHTML = `<p>${data.error}</p>`;
            }
        })
        .catch(error => {
            commentsContainer.innerHTML = `<p>Failed to load comments: ${error}</p>`;
        });
});