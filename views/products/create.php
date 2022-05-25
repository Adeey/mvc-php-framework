<form action="/index.php/product/create_submit" method="post">
    <?php
    if ($items['errors']) {
        echo '<p>' . $items['errors']['message'] . '</p>';
    }
    ?>
    Name: <input type="text" name="name" /><br/>
    Status:
    <select name="status">
        <?php
        foreach ($items['statuses'] as $status) {
            echo '<option value="' . $status['id'] . '">' . $status['name'] . '</option>';
        }
        ?>
        ?>
    </select> <br/>
    Category:
    <select name="category">
        <?php
        foreach ($items['category'] as $category) {
            echo '<option value="' . $category['id'] . '" ' . ($items['product']['categoryName'] === $category['name'] ? 'selected' : null) . '>' . $category['name'] . '</option>';
        }
        ?>
        ?>
    </select>
    <br/>
    Description: <input type="text" name="description" /><br/>
    <input type="submit" value="submit creating">
</form>
