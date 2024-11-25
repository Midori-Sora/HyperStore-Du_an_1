<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slideshow</title>
    <link rel="stylesheet" href="assets/css/client/slideshow.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="slideshow">
        <img src="Uploads/Slides/b1.png" alt="">
        <img src="Uploads/Slides/b2.png" alt="">
        <img src="Uploads/Slides/b3.png" alt="">
        <img src="Uploads/Slides/b4.png" alt="">
        <img src="Uploads/Slides/b5.png" alt="">
        <img src="Uploads/Slides/b6.png" alt="">
        <img src="Uploads/Slides/b7.png" alt="">
        <img src="Uploads/Slides/b9.webp" alt="">
        <img src="Uploads/Slides/b8.webp" alt="">
        <img src="Uploads/Slides/b13.webp" alt="">
        <div class="action">
            <div class="prev"><i class="fa-solid fa-angle-left"></i></div>
            <div class="next"><i class="fa-solid fa-angle-right"></i></div>
        </div>
    </div>
    <script>
        let currentIndex = 0; // Chỉ số hình ảnh hiện tại
        const slides = document.querySelectorAll('.slideshow img'); // Lấy tất cả hình ảnh trong slideshow

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = (i === index) ? 'block' : 'none'; // Hiển thị hình ảnh hiện tại
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length; // Tăng chỉ số và quay lại nếu vượt quá số hình ảnh
            showSlide(currentIndex);
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length; // Giảm chỉ số và quay lại nếu dưới 0
            showSlide(currentIndex);
        }

        let slideInterval = setInterval(nextSlide, 3000); // Tự động chuyển slide mỗi 3 giây

        // Hiển thị slide đầu tiên
        showSlide(currentIndex);

        // Thêm sự kiện click cho nút "prev" và "next"
        document.querySelector('.prev').addEventListener('click', prevSlide); // Xử lý nút "prev"
        document.querySelector('.next').addEventListener('click', nextSlide); // Xử lý nút "next"
    </script>
</body>
</html>