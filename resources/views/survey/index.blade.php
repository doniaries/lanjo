<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Survey Wisata - {{ $attraction->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .star-rating {
            display: flex;
            gap: 0.5rem;
            font-size: 2rem;
        }

        .star {
            cursor: pointer;
            transition: all 0.2s;
            filter: grayscale(100%);
        }

        .star.active {
            filter: grayscale(0%);
            transform: scale(1.2);
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-green-600 text-white p-8 text-center">
            <h1 class="text-3xl font-bold mb-2">Survey Kepuasan Pengunjung</h1>
            <p class="text-lg opacity-90">{{ $attraction->nama }}</p>
        </div>

        <!-- Form Container -->
        <div class="p-8" id="surveyForm">
            <!-- Step 1: Language Selection -->
            <div class="step active" data-step="1">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Pilih Bahasa / Choose Language</h2>
                <div class="grid grid-cols-2 gap-4">
                    <button onclick="selectLanguage('id')" class="lang-btn bg-blue-500 hover:bg-blue-600 text-white font-bold py-6 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg">
                        <span class="text-4xl mb-2 block">🇮🇩</span>
                        Bahasa Indonesia
                    </button>
                    <button onclick="selectLanguage('en')" class="lang-btn bg-green-500 hover:bg-green-600 text-white font-bold py-6 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg">
                        <span class="text-4xl mb-2 block">🇬🇧</span>
                        English
                    </button>
                </div>
            </div>

            <!-- Step 2: Visitor Profile -->
            <div class="step" data-step="2">
                <h2 class="text-2xl font-bold text-gray-800 mb-6" id="profileTitle">Data Pengunjung</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2" id="nameLabel">Nama Lengkap</label>
                        <input type="text" id="visitor_name" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2" id="ageLabel">Umur</label>
                        <input type="number" id="visitor_age" min="1" max="120" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2" id="originLabel">Asal</label>
                        <select id="visitor_origin" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" required>
                            <option value="">-- Pilih --</option>
                            <option value="lokal">Lokal Sijunjung</option>
                            <option value="domestik">Luar Daerah</option>
                            <option value="mancanegara">Mancanegara</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex gap-4">
                    <button onclick="prevStep()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                        <span id="backBtn">Kembali</span>
                    </button>
                    <button onclick="nextStep()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        <span id="nextBtn">Lanjut</span>
                    </button>
                </div>
            </div>

            <!-- Step 3: Ratings -->
            <div class="step" data-step="3">
                <h2 class="text-2xl font-bold text-gray-800 mb-6" id="ratingTitle">Penilaian</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3" id="facilityLabel">Fasilitas</label>
                        <div class="star-rating" id="rating_facility">
                            <span class="star" data-value="1">⭐</span>
                            <span class="star" data-value="2">⭐</span>
                            <span class="star" data-value="3">⭐</span>
                            <span class="star" data-value="4">⭐</span>
                            <span class="star" data-value="5">⭐</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3" id="cleanlinessLabel">Kebersihan</label>
                        <div class="star-rating" id="rating_cleanliness">
                            <span class="star" data-value="1">⭐</span>
                            <span class="star" data-value="2">⭐</span>
                            <span class="star" data-value="3">⭐</span>
                            <span class="star" data-value="4">⭐</span>
                            <span class="star" data-value="5">⭐</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3" id="serviceLabel">Pelayanan</label>
                        <div class="star-rating" id="rating_service">
                            <span class="star" data-value="1">⭐</span>
                            <span class="star" data-value="2">⭐</span>
                            <span class="star" data-value="3">⭐</span>
                            <span class="star" data-value="4">⭐</span>
                            <span class="star" data-value="5">⭐</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex gap-4">
                    <button onclick="prevStep()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                        <span id="backBtn2">Kembali</span>
                    </button>
                    <button onclick="nextStep()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        <span id="nextBtn2">Lanjut</span>
                    </button>
                </div>
            </div>

            <!-- Step 4: Comment -->
            <div class="step" data-step="4">
                <h2 class="text-2xl font-bold text-gray-800 mb-6" id="commentTitle">Kesan & Pesan (Opsional)</h2>
                <textarea id="comment" rows="5" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" id="commentPlaceholder" placeholder="Tuliskan kesan dan saran Anda..."></textarea>
                <div class="mt-6 flex gap-4">
                    <button onclick="prevStep()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                        <span id="backBtn3">Kembali</span>
                    </button>
                    <button onclick="submitSurvey()" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        <span id="submitBtn">Kirim Survey</span>
                    </button>
                </div>
            </div>

            <!-- Thank You Page -->
            <div class="step" data-step="5">
                <div class="text-center py-8">
                    <div class="text-6xl mb-4">✅</div>
                    <h2 class="text-3xl font-bold text-green-600 mb-4" id="thankYouTitle">Terima Kasih!</h2>
                    <p class="text-gray-600 text-lg mb-6" id="thankYouMessage">Survey Anda telah berhasil dikirim.</p>
                    <img src="{{ asset('images/logo.png') }}" alt="Geopark Sijunjung" class="mx-auto h-24 mb-4">
                    <p class="text-gray-500">Geopark Sijunjung</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let selectedLanguage = 'id';
        let ratings = {
            facility: 0,
            cleanliness: 0,
            service: 0
        };

        const translations = {
            id: {
                profileTitle: 'Data Pengunjung',
                nameLabel: 'Nama Lengkap',
                ageLabel: 'Umur',
                originLabel: 'Asal',
                ratingTitle: 'Penilaian',
                facilityLabel: 'Fasilitas',
                cleanlinessLabel: 'Kebersihan',
                serviceLabel: 'Pelayanan',
                commentTitle: 'Kesan & Pesan (Opsional)',
                commentPlaceholder: 'Tuliskan kesan dan saran Anda...',
                backBtn: 'Kembali',
                nextBtn: 'Lanjut',
                submitBtn: 'Kirim Survey',
                thankYouTitle: 'Terima Kasih!',
                thankYouMessage: 'Survey Anda telah berhasil dikirim.'
            },
            en: {
                profileTitle: 'Visitor Information',
                nameLabel: 'Full Name',
                ageLabel: 'Age',
                originLabel: 'Origin',
                ratingTitle: 'Ratings',
                facilityLabel: 'Facilities',
                cleanlinessLabel: 'Cleanliness',
                serviceLabel: 'Service',
                commentTitle: 'Comments (Optional)',
                commentPlaceholder: 'Write your feedback and suggestions...',
                backBtn: 'Back',
                nextBtn: 'Next',
                submitBtn: 'Submit Survey',
                thankYouTitle: 'Thank You!',
                thankYouMessage: 'Your survey has been successfully submitted.'
            }
        };

        function selectLanguage(lang) {
            selectedLanguage = lang;
            updateLanguage();
            nextStep();
        }

        function updateLanguage() {
            const t = translations[selectedLanguage];
            document.getElementById('profileTitle').textContent = t.profileTitle;
            document.getElementById('nameLabel').textContent = t.nameLabel;
            document.getElementById('ageLabel').textContent = t.ageLabel;
            document.getElementById('originLabel').textContent = t.originLabel;
            document.getElementById('ratingTitle').textContent = t.ratingTitle;
            document.getElementById('facilityLabel').textContent = t.facilityLabel;
            document.getElementById('cleanlinessLabel').textContent = t.cleanlinessLabel;
            document.getElementById('serviceLabel').textContent = t.serviceLabel;
            document.getElementById('commentTitle').textContent = t.commentTitle;
            document.getElementById('comment').placeholder = t.commentPlaceholder;
            document.querySelectorAll('#backBtn, #backBtn2, #backBtn3').forEach(el => el.textContent = t.backBtn);
            document.querySelectorAll('#nextBtn, #nextBtn2').forEach(el => el.textContent = t.nextBtn);
            document.getElementById('submitBtn').textContent = t.submitBtn;
            document.getElementById('thankYouTitle').textContent = t.thankYouTitle;
            document.getElementById('thankYouMessage').textContent = t.thankYouMessage;
        }

        function nextStep() {
            if (currentStep === 2 && !validateProfile()) return;
            if (currentStep === 3 && !validateRatings()) return;

            document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
            currentStep++;
            document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
        }

        function prevStep() {
            document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
            currentStep--;
            document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
        }

        function validateProfile() {
            const name = document.getElementById('visitor_name').value;
            const age = document.getElementById('visitor_age').value;
            const origin = document.getElementById('visitor_origin').value;

            if (!name || !age || !origin) {
                alert(selectedLanguage === 'id' ? 'Mohon lengkapi semua data' : 'Please complete all fields');
                return false;
            }
            return true;
        }

        function validateRatings() {
            if (ratings.facility === 0 || ratings.cleanliness === 0 || ratings.service === 0) {
                alert(selectedLanguage === 'id' ? 'Mohon berikan rating untuk semua kategori' : 'Please rate all categories');
                return false;
            }
            return true;
        }

        // Star rating functionality
        document.querySelectorAll('.star-rating').forEach(container => {
            const stars = container.querySelectorAll('.star');
            const ratingType = container.id.replace('rating_', '');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.dataset.value);
                    ratings[ratingType] = value;

                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });
        });

        async function submitSurvey() {
            const data = {
                tempat_wisata_id: {
                    {
                        $attraction - > id
                    }
                },
                bahasa: selectedLanguage,
                nama_pengunjung: document.getElementById('visitor_name').value,
                umur_pengunjung: document.getElementById('visitor_age').value,
                asal_pengunjung: document.getElementById('visitor_origin').value,
                rating_fasilitas: ratings.facility,
                rating_kebersihan: ratings.cleanliness,
                rating_pelayanan: ratings.service,
                komentar: document.getElementById('comment').value
            };

            try {
                const response = await fetch('{{ route("survey.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    nextStep(); // Go to thank you page
                } else {
                    alert(selectedLanguage === 'id' ? 'Terjadi kesalahan' : 'An error occurred');
                }
            } catch (error) {
                console.error('Error:', error);
                alert(selectedLanguage === 'id' ? 'Terjadi kesalahan' : 'An error occurred');
            }
        }
    </script>
</body>

</html>