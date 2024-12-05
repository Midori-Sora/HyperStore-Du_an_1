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
    <?php
   
    require_once './admin/models/bannerModel.php';

    $bannerModel = new BannerModel();
    $banners = $bannerModel->getActiveBanners();
    ?>

    <div class="slideshow">
        <?php if (!empty($banners)): ?>
        <?php foreach ($banners as $banner): ?>
        <img src="Uploads/Slides/<?= htmlspecialchars($banner['image_url']) ?>"
            alt="<?= htmlspecialchars($banner['title']) ?>" style="display: none;">
        <?php endforeach; ?>

        <div class="action">
            <div class="prev"><i class="fa-solid fa-angle-left"></i></div>
            <div class="next"><i class="fa-solid fa-angle-right"></i></div>
        </div>
        <?php else: ?>
        <p>Không có banner nào được hiển thị</p>
        <?php endif; ?>
    </div>

    <script>
    const slides = document.querySelectorAll('.slideshow img');
    if (slides.length > 0) {
        let currentIndex = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = (i === index) ? 'block' : 'none';
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(currentIndex);
        }


        showSlide(0);
        let slideInterval = setInterval(nextSlide, 3000);


        document.querySelector('.prev').addEventListener('click', () => {
            clearInterval(slideInterval);
            prevSlide();
            slideInterval = setInterval(nextSlide, 3000);
        });

        document.querySelector('.next').addEventListener('click', () => {
            clearInterval(slideInterval);
            nextSlide();
            slideInterval = setInterval(nextSlide, 3000);
        });
    }
    </script>
</body>

</html>