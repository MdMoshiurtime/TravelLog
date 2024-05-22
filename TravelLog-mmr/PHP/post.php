<?php
function displayPosts($sql, $conn, $num, $username=null)
{
    // Execute the query and check for errors
    $result = $conn->query($sql);
    
    if (!$result) {
        // Query failed, handle error
        echo "Error: " . $conn->error;
        return;
    }

    if ($result->num_rows > 0) {
        while ($post = $result->fetch_assoc()) {
?>
            <!-- One Post -->
            <div id="main-window">
                <div class="post">
                    <div class="user">
                        <div class="user-stuff">
                            <div class="user-img">
                                <?php
                                if ($post['profile_img'] != NULL) {
                                    echo '<img style="width: 35px; height: 35px;" src="data:image/jpeg;base64,' . base64_encode($post['profile_img']) . '"/>';
                                } else {
                                ?>
                                    <img class="media-object" style="width: 35px; height: 35px;" alt="Portrait Placeholder" src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="user-info">
                                <div class="user-name">
                                    <a href="profile.php?username=<?php echo htmlspecialchars($post['username']); ?>">
                                        <?php echo htmlspecialchars($post['name']); ?>
                                    </a>
                                </div>
                                <span class="post-date"><?php echo htmlspecialchars($post['created_at']); ?></span>
                            </div>
                        </div>
                        <?php
                        if ($num === 1 && $username == $_SESSION['username']) {
                        ?>
                            <div class="actions">
                                <span class="share"></span>
                                <form method="post" action="delete-post.php" id="delete-post" name="delete-post">
                                    <span>
                                        <a class="text-danger" href="delete-post.php?id=<?php echo htmlspecialchars($post['post_id']); ?>">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </span>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="content">
                        <?php
                        if ($post['content_img'] != NULL) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($post['content_img']) . '"/>';
                        }
                        echo htmlspecialchars($post['content']);
                        ?>
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        ?>
        <p class="text-center">No posts yet!</p>
    <?php
    }
    $conn->close();
}
?>
