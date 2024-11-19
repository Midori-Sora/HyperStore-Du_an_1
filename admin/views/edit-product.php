<form method="POST" action="index.php?action=updateCategory">
    <input type="hidden" name="cate_id" value="<?php echo $category['cate_id']; ?>">
    <label>Tên danh mục:</label>
    <input type="text" name="cate_name" value="<?php echo $category['cate_name']; ?>" required>

    <label>Ảnh:</label>
    <input type="text" name="img" value="<?php echo $category['img']; ?>">

    <label>Mô tả:</label>
    <textarea name="description"><?php echo $category['description']; ?></textarea>

    <label>Trạng thái:</label>
    <select name="cate_status">
        <option value="1" <?php echo ($category['cate_status'] == 1) ? 'selected' : ''; ?>>Hoạt động</option>
        <option value="0" <?php echo ($category['cate_status'] == 0) ? 'selected' : ''; ?>>Không hoạt động</option>
    </select>

    <button type="submit">Cập nhật danh mục</button>
</form>