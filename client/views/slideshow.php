<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/client/slideshow.css">
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="slideshow">
        <img src="../../Uploads/Slides/b2.png" alt="">  
        <img src="../../Uploads/Slides/b3.png" alt="">
        <img src="../../Uploads/Slides/b4.png" alt="">
        <img src="../../Uploads/Slides/b5.png" alt="">
        <img src="../../Uploads/Slides/b6.png" alt="">
        <img src="../../Uploads/Slides/b7.png" alt="">
        <div class="action">
            <div class="prev"><i class="fa-solid fa-angle-left"></i></div>
            <div class="next"><i class="fa-solid fa-angle-right"></i></div>
        </div>
    </div>

    <script>
        const slideshow = document.querySelector('.slideshow');
        const slides = slideshow.querySelectorAll('img');
        const prev = slideshow.querySelector('.prev');
        const next = slideshow.querySelector('.next');
        const playPauseBtn = slideshow.querySelector('.play-pause');
        
        let currentSlide = 0;
        let isPlaying = true;
        let slideInterval = setInterval(nextSlide, 2000); // Chạy tự động mỗi 3 giây
        
        // Ẩn tất cả slides trừ slide đầu tiên
        slides.forEach((slide, index) => {
            if (index !== 0) slide.style.display = 'none';
        });
        
        function nextSlide() {
            slides[currentSlide].style.display = 'none';
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].style.display = 'block';
        }
        
        function prevSlide() {
            slides[currentSlide].style.display = 'none';
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            slides[currentSlide].style.display = 'block';
        }
        
        // Xử lý nút Next
        next.addEventListener('click', () => {
            nextSlide();
            // Reset interval khi click
            clearInterval(slideInterval);
            if (isPlaying) slideInterval = setInterval(nextSlide, 3000);
        });
        
        // Xử lý nút Previous
        prev.addEventListener('click', () => {
            prevSlide();
            // Reset interval khi click
            clearInterval(slideInterval);
            if (isPlaying) slideInterval = setInterval(nextSlide, 3000);
        });
    </script>
</body>
</html>