console.log('post-interactions.js loaded');

// Ensure the CSRF token is being sent correctly
const headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
};

document.addEventListener('DOMContentLoaded', () => {
    // Handle like button click
    document.body.addEventListener('click', async (event) => {
        if (event.target.closest('.like-button')) {
            const button = event.target.closest('.like-button');
            const postId = button.closest('.post').dataset.postId;
            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: headers,
                });

                const data = await response.json();
                if (data.success) {
                    updateLikeButton(button, data);
                } else {
                    console.error('Error toggling like:', data.message);
                    alert('Failed to toggle like. Please try again.');
                }
            } catch (error) {
                console.error('Error toggling like:', error);
                alert('An error occurred while toggling like. Please try again.');
            }
        }
    });

    // Handle comment form submission
    document.body.addEventListener('submit', async (event) => {
        if (event.target.matches('.comment-form')) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const postId = form.closest('.post').dataset.postId;

            try {
                const response = await fetch(`/posts/${postId}/comments`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                });

                const data = await response.json();
                if (data.success) {
                    addCommentToDOM(form.closest('.post'), data.comment, data.user);
                    form.reset();
                    updateCommentCount(form.closest('.post'), 1);
                } else {
                    console.error('Error adding comment:', data.message);
                    alert('Failed to add comment. Please try again.');
                }
            } catch (error) {
                console.error('Error adding comment:', error);
                alert('An error occurred while adding the comment. Please try again.');
            }
        }
    });

    // Show reaction options on hover
    document.body.addEventListener('mouseenter', (event) => {
        const reactionButton = event.target.closest('.reaction-button');
        console.log('Reaction button found:', reactionButton);
        if (reactionButton) {
            const options = reactionButton.closest('.relative').querySelector('.reaction-options');
            console.log('Reaction options found:', options);
            if (options) {
                options.classList.remove('hidden');
                options.style.display = 'flex';
            }
        }
    }, true);

    document.body.addEventListener('mouseleave', (event) => {
        const reactionGroup = event.target.closest('.relative');
        if (reactionGroup) {
            const options = reactionGroup.querySelector('.reaction-options');
            if (options && !options.matches(':hover')) {
                options.classList.add('hidden');
            }
        }
    }, true);

    // Handle reaction button click
    document.body.addEventListener('click', async (event) => {
        if (event.target.matches('.reaction-btn')) {
            const button = event.target;
            const postId = button.closest('.post').dataset.postId;
            const reaction = button.dataset.reaction;

            // Add pop-out animation
            button.classList.add('pop-out');
            setTimeout(() => {
                button.classList.remove('pop-out');
            }, 300);

            try {
                const response = await fetch(`/posts/${postId}/react`, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({ reaction }),
                });

                const data = await response.json();
                if (response.ok) {
                    updateReactionsDisplay(button.closest('.post'), data);
                }
            } catch (error) {
                console.error('Error reacting to post:', error);
            }
        }
    });

    // Handle comment actions (reply, edit, delete)
    document.body.addEventListener('click', async (event) => {
        if (event.target.matches('.reply-comment')) {
            handleReplyComment(event);
        } else if (event.target.matches('.edit-comment')) {
            handleEditComment(event);
        } else if (event.target.matches('.delete-comment')) {
            handleDeleteComment(event);
        }
    });

    // Handle reply form submission
    document.body.addEventListener('submit', async (event) => {
        if (event.target.matches('.reply-form')) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const postId = form.closest('.post').dataset.postId;

            try {
                const response = await fetch(`/posts/${postId}/comments`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                });

                const data = await response.json();
                if (response.ok) {
                    addReplyToDOM(form.closest('.comment'), data.comment, data.user);
                    form.reset();
                    form.classList.add('hidden');
                    updateCommentCount(form.closest('.post'), 1);
                } else {
                    console.error('Error adding reply:', data.message);
                    alert('Failed to add reply. Please try again.');
                }
            } catch (error) {
                console.error('Error adding reply:', error);
                alert('An error occurred while adding the reply. Please try again.');
            }
        }
    });

    // Toggle comments visibility
    document.body.addEventListener('click', (event) => {
        if (event.target.closest('.comment-toggle-button')) {
            const post = event.target.closest('.post');
            const commentsSection = post.querySelector('.comments-section');
            commentsSection.classList.toggle('hidden');
        }
    });

    // View more comments
    document.body.addEventListener('click', (event) => {
        if (event.target.matches('.view-more-comments')) {
            // Implement logic to load more comments
            console.log('Load more comments');
        }
    });

    // Handle share button click
    document.body.addEventListener('click', (event) => {
        if (event.target.closest('.share-button')) {
            const button = event.target.closest('.share-button');
            const post = button.closest('.post');
            const postId = post.dataset.postId;
            const shareModal = document.getElementById('shareModal');
            const shareForm = shareModal.querySelector('#shareForm');
            
            // Set the form action
            shareForm.action = `/posts/${postId}/share`;
            
            // Populate original post details
            document.getElementById('shareOriginalUserImg').src = post.querySelector('img').src;
            document.getElementById('shareOriginalUserName').textContent = post.querySelector('h3').textContent;
            document.getElementById('shareOriginalPostDate').textContent = post.querySelector('.text-gray-500').textContent;
            document.getElementById('shareOriginalContent').textContent = post.querySelector('p').textContent;
            
            // Show the modal
            shareModal.classList.remove('hidden');
        }
    });

    // Close share modal
    document.getElementById('closeShareModal').addEventListener('click', function() {
        document.getElementById('shareModal').classList.add('hidden');
    });

    // Handle share form submission
    document.getElementById('shareForm').addEventListener('submit', async (event) => {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            if (data.success) {
                alert('Post shared successfully!');
                document.getElementById('shareModal').classList.add('hidden');
                // Optionally, update the UI to show the new shared post
            } else {
                throw new Error(data.message || 'Failed to share post');
            }
        } catch (error) {
            console.error('Error sharing post:', error);
            alert('An error occurred while sharing the post. Please try again.');
        }
    });
});

async function handleEditComment(event) {
    const comment = event.target.closest('.comment');
    if (!comment) return;

    const commentId = comment.dataset.commentId;
    const commentContent = comment.querySelector('.comment-content');
    if (!commentContent) return;

    const currentContent = commentContent.textContent.trim();

    const editForm = document.createElement('form');
    editForm.classList.add('edit-comment-form', 'mt-2', 'flex', 'items-center');
    editForm.innerHTML = `
        <input type="text" class="flex-grow p-2 border rounded-l-full" value="${currentContent}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-full">Send</button>
    `;

    commentContent.replaceWith(editForm);
    const input = editForm.querySelector('input');
    input.focus();

    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const newContent = input.value.trim();
        if (newContent !== currentContent) {
            try {
                const response = await fetch(`/comments/${commentId}`, {
                    method: 'PATCH',
                    headers: {
                        ...headers,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ content: newContent }),
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Error response:', errorText);
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.success) {
                    commentContent.textContent = newContent;
                    alert('Comment updated successfully');
                } else {
                    throw new Error(data.message || 'Failed to update comment');
                }
            } catch (error) {
                console.error('Error updating comment:', error);
                alert(`An error occurred while updating the comment: ${error.message}`);
            }
        }
        editForm.replaceWith(commentContent);
    });
}

async function handleDeleteComment(event) {
    if (!confirm('Are you sure you want to delete this comment?')) return;

    const comment = event.target.closest('.comment');
    if (!comment) return;

    const commentId = comment.dataset.commentId;

    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: headers,
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            comment.remove();
            updateCommentCount(comment.closest('.post'), -1);
            alert('Comment deleted successfully');
        } else {
            throw new Error(data.message || 'Failed to delete comment');
        }
    } catch (error) {
        console.error('Error deleting comment:', error);
        alert(`An error occurred while deleting the comment: ${error.message}`);
    }
}

function updateLikeButton(button, data) {
    const likeIcon = button.querySelector('i');
    const likeText = button.querySelector('span');
    const reactionsCount = button.closest('.post').querySelector('.reactions-count');

    if (likeIcon) {
        likeIcon.classList.toggle('fas', data.liked);
        likeIcon.classList.toggle('far', !data.liked);
    }

    if (likeText) {
        likeText.textContent = data.liked ? 'Liked' : 'Like';
    }

    if (reactionsCount) {
        const countSpan = reactionsCount.querySelector('span') || reactionsCount;
        countSpan.textContent = `${data.likesCount} ${data.likesCount === 1 ? 'reaction' : 'reactions'}`;
    }
}

function addCommentToDOM(post, comment, user) {
    const commentHtml = createCommentHtml(comment, user);
    post.querySelector('.comments-section').insertAdjacentHTML('beforeend', commentHtml);
}

function addReplyToDOM(parentComment, reply, user) {
    const replyHtml = createCommentHtml(reply, user);
    parentComment.insertAdjacentHTML('afterend', replyHtml);
}

function updateReactionsDisplay(post, data) {
    const reactionButton = post.querySelector('.reaction-button');
    const reactionIcon = reactionButton.querySelector('i');
    const reactionText = reactionButton.querySelector('span');
    const reactionsCount = post.querySelector('.reactions-count');

    // Update the main reaction button
    if (data.userReaction) {
        reactionIcon.className = getReactionIcon(data.userReaction);
        reactionText.textContent = capitalizeFirstLetter(data.userReaction);
        reactionText.className = getReactionTextColor(data.userReaction);
        
        // Add pop-out animation to the main reaction button
        reactionButton.classList.add('pop-out');
        setTimeout(() => {
            reactionButton.classList.remove('pop-out');
        }, 300);
    } else {
        reactionIcon.className = 'far fa-thumbs-up mr-2';
        reactionText.textContent = 'Like';
        reactionText.className = '';
    }

    // Update the reactions count
    if (reactionsCount) {
        const countSpan = reactionsCount.querySelector('span') || reactionsCount;
        countSpan.textContent = `${data.reactionsCount} ${data.reactionsCount === 1 ? 'reaction' : 'reactions'}`;
    }

    // Update top reactions display
    const topReactionsContainer = post.querySelector('.reactions-count .flex');
    if (topReactionsContainer) {
        topReactionsContainer.innerHTML = data.topReactions.map(reaction => `
            <span class="inline-block rounded-full text-sm" title="${capitalizeFirstLetter(reaction)}">${getReactionEmoji(reaction)}</span>
        `).join('');
    }
}

function updateCommentCount(post, change) {
    const commentCountElement = post.querySelector('.comment-count');
    if (commentCountElement) {
        const currentCount = parseInt(commentCountElement.textContent);
        const newCount = currentCount + change;
        commentCountElement.textContent = `${newCount} ${newCount === 1 ? 'comment' : 'comments'}`;
    }
}

function createCommentHtml(comment, user) {
    return `
        <div class="comment flex items-start mb-3" data-comment-id="${comment.id}">
            <img src="${user.profile_picture_url}" alt="${user.name}" class="w-8 h-8 rounded-full mr-2 object-cover">
            <div class="flex-grow">
                <div class="bg-gray-100 p-2 rounded-2xl">
                    <h4 class="font-semibold text-sm">${user.name}</h4>
                    <p class="text-sm comment-content">${comment.content}</p>
                </div>
                <div class="mt-1 text-xs text-gray-500 flex items-center">
                    <button class="reply-comment mr-2 hover:underline">Reply</button>
                    ${comment.user_id === user.id ? `
                        <button class="edit-comment mr-2 hover:underline">Edit</button>
                        <button class="delete-comment hover:underline">Delete</button>
                    ` : ''}
                    <span class="text-xs text-gray-400 ml-auto">${new Date(comment.created_at).toLocaleString()}</span>
                </div>
                <form class="reply-form mt-2 hidden">
                    <input type="hidden" name="parent_id" value="${comment.id}">
                    <div class="flex items-center">
                        <input type="text" name="content" class="flex-grow p-2 border rounded-l-full" placeholder="Write a reply...">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-full">Send</button>
                    </div>
                </form>
            </div>
        </div>
    `;
}

function handleReplyComment(event) {
    const commentElement = event.target.closest('.comment');
    const replyForm = commentElement.querySelector('.reply-form');
    replyForm.classList.toggle('hidden');
}

function getReactionIcon(reaction) {
    switch (reaction) {
        case 'like': return 'fas fa-thumbs-up text-blue-500 mr-2';
        case 'love': return 'fas fa-heart text-red-500 mr-2';
        case 'haha': return 'fas fa-laugh-squint text-yellow-500 mr-2';
        case 'wow': return 'fas fa-surprise text-yellow-500 mr-2';
        case 'sad': return 'fas fa-sad-tear text-yellow-500 mr-2';
        case 'angry': return 'fas fa-angry text-red-500 mr-2';
        default: return 'far fa-thumbs-up mr-2';
    }
}

function getReactionEmoji(reaction) {
    switch (reaction) {
        case 'like': return '👍';
        case 'love': return '❤️';
        case 'haha': return '😆';
        case 'wow': return '😮';
        case 'sad': return '😢';
        case 'angry': return '😠';
        default: return '👍';
    }
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function getReactionTextColor(reaction) {
    switch (reaction) {
        case 'like': return 'text-blue-500';
        case 'love': return 'text-red-500';
        case 'haha':
        case 'wow':
        case 'sad': return 'text-yellow-500';
        case 'angry': return 'text-red-500';
        default: return '';
    }
}

function updateShareCount(post, sharesCount) {
    const shareCountElement = post.querySelector('.share-count');
    if (shareCountElement) {
        shareCountElement.textContent = `${sharesCount} ${sharesCount === 1 ? 'share' : 'shares'}`;
    }
}
