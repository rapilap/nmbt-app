<x-app-layout title="Sewa" bodyClass="bg-tertiery3 w-full items-center min-h-screen text-tertiery1">
    <div class="w-full px-10">
        <div class="breadcrumbs text-sm text-tertiery1 mt-4">
            <ul>
                <li><a href="/products">NMBT</a></li>
                <li><a href="/products?category[0]={{ $product->category->id }}">{{ $product->category->category_name }}</a></li>
                <li>{{ $product->name }}</li>
            </ul>
        </div>
        {{-- Main Content --}}
        <div class="bg-white rounded mt-2 drop-shadow-md w-full mb-6 p-10">

            {{-- Product Content --}}
            <div class="flex gap-8">

                {{-- Carousel --}}
                <div class="w-2/4">
                    <div class="relative w-full mx-auto">
                        <!-- Main Image -->
                        <div class="overflow-hidden rounded-lg">
                            <img id="main-image" src="{{ isset($product->images[0]) ? asset('storage/' . $product->images[0]->image_path) : asset('images/produk-icon-dummy.png') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full aspect-square object-cover transition-all duration-300">
                        </div>

                        <!-- Controls -->
                        <div class="flex mt-4 gap-2 justify-center">
                            <button id="prev" class="bg-base-100 p-2 rounded-md drop-shadow hover:bg-base-200">
                                &#8592;
                            </button>
                            <!-- Thumbnails -->
                            <div class="flex space-x-2 justify-center">
                                @if ($product->images->isNotEmpty())
                                    @foreach ($product->images as $image)
                                        <img
                                            id="images-{{ $loop->index }}"
                                            src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="Thumbnail {{ $loop->index }}"
                                            class="thumbnail w-16 h-16 object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-primary transition-all">
                                    @endforeach
                                @else
                                    <img
                                        id="images-0"
                                        src="{{ asset('images/produk-icon-dummy.png') }}"
                                        alt="Thumbnail Dummy"
                                        class="thumbnail w-16 h-16 object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-primary transition-all">
                                @endif
                            </div>
                            <button id="next" class="bg-base-100 p-2 rounded-md drop-shadow hover:bg-base-200">
                                &#8594;
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Carousel End --}}

                {{-- Description Content --}}
                <div class="w-full h-full">
                    <div class="text-3xl font-medium">
                        {{ $product->name }}
                    </div>
                    <div class="flex gap-3 mt-2">
                        <div class="flex items-center gap-2">
                            <span class="border-b-2 w-full">4,6</span>
                            <div class="flex space-x-1 lg:text-xl 2xl:text-3xl">
                                <button type="button" class="text-yellow-500 "
                                    id="star1">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star2">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star3">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star4">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star5">&#9733;</button>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="border-b-2 w-full">178</span>
                            <p>Reviews</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="border-b-2 w-full">215</span>
                            <p>Rent</p>
                        </div>
                    </div>
                    <div class="py-5">
                        {{ $product->description }}
                    </div>
                    <div class="flex justify-between text-secondary3">
                        <span class="font-medium text-3xl">
                            Rp. {{ number_format($product->price ?? 0, 2, ',', '.') }}
                        </span>
                        <div class="flex items-center space-x-2">
                            <button id="decrease" class="bg-base-100 px-3 border border-secondary3 h-full rounded-md hover:bg-secondary3 hover:text-bg3 transition">
                                -
                            </button>
                            <input
                                id="quantity"
                                type="text"
                                value="1"
                                class="w-10 h-full focus:outline-none text-center border border-secondary3 rounded-md"
                                readonly>
                            <button id="increase" class="bg-base-100 px-3 rounded-md border border-secondary3 h-full hover:bg-secondary3 hover:text-bg3 transition">
                                +
                            </button>
                        </div>
                    </div>
                    <div class="w-full flex justify-end mt-5">
                        <x-button variant="secondary">Add To Cart</x-button>
                    </div>
                </div>
                {{-- Description Content End--}}

            </div>
            <div>
                <h1>Reviews</h1>
            </div>
        </div>
        {{-- Main Content End --}}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const images = @json($product->images);
            const mainImage = document.getElementById("main-image");
            const thumbnails = document.querySelectorAll(".thumbnail");
            const prevBtn = document.getElementById("prev");
            const nextBtn = document.getElementById("next");
            const quantityInput = document.getElementById("quantity");
            const increaseBtn = document.getElementById("increase");
            const decreaseBtn = document.getElementById("decrease");
            let currentIndex = 0;

            // Update main image and active thumbnail
            const updateMainImage = (index) => {
                mainImage.src = `{{ asset('storage/') }}/${images[index].image_path}`;

                // Remove 'border-primary' class from all thumbnails
                thumbnails.forEach((thumbnail) => thumbnail.classList.remove("border-primary"));

                // Add 'border-primary' class to the active thumbnail
                thumbnails[index].classList.add("border-primary");
            };

            // Add click event to thumbnails
            thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener("click", () => {
                    currentIndex = index;
                    updateMainImage(currentIndex);
                });
            });

            // Prev button click
            prevBtn.addEventListener("click", () => {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateMainImage(currentIndex);
            });

            // Next button click
            nextBtn.addEventListener("click", () => {
                currentIndex = (currentIndex + 1) % images.length;
                updateMainImage(currentIndex);
            });

            // Initialize with the first image and active thumbnail
            updateMainImage(currentIndex);

            increaseBtn.addEventListener("click", () => {
                const currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });

            decreaseBtn.addEventListener("click", () => {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
        });
    </script>
</x-app-layout>