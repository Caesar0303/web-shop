<template>
    <AppLayout title="Посмотреть объявление">
        <template #header>
            <div class="flex justify-between items-center py-4">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Посмотреть объявление
                </h2>

            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">{{ ad.header }}</h3>
                        <button
                            class="heart-icon"
                            @click="toggleHeart(ad)"
                        >
                            <img
                                v-if="!ad.isHearted"
                                src="../../../../public/storage/icons/icons8-сердце-50.png"
                                alt="Добавить в избранное"
                                class="w-6 h-6 heart-img"
                            />
                            <img
                                v-else
                                src="../../../../public/storage/icons/icons8-сердце2-50.png"
                                alt="Убрать из избранного"
                                class="w-6 h-6 heart-img"
                            />
                        </button>
                    </div>
                    <div class="flex">
                        <div class="w-1/2 pr-4">
                            <v-slider v-bind="options">
                                <div v-if="ad.img_1" class="item">
                                    <img :src="`/storage/${ad.img_1}`" alt="Image 1" class="rounded-lg w-full">
                                </div>
                                <div v-if="ad.img_2" class="item">
                                    <img :src="`/storage/${ad.img_2}`" alt="Image 2" class="rounded-lg w-full">
                                </div>
                                <div v-if="ad.img_3" class="item">
                                    <img :src="`/storage/${ad.img_3}`" alt="Image 3" class="rounded-lg w-full">
                                </div>
                            </v-slider>
                        </div>
                        <div class="w-1/2 pl-4">
                            <div class="bg-gray-100 rounded p-4">
                                <p class="text-xl font-semibold mb-4">{{ ad.title }}</p>
                                <p class="mb-2"><strong>Описание:</strong> {{ ad.description }}</p>
                                <p class="mb-2"><strong>Телефон:</strong> {{ ad.phone_number }}</p>
                                <p class="mb-2"><strong>Количество:</strong> {{ ad.quantity }}</p>
                                <p class="mb-2"><strong>Цена:</strong> {{ ad.price }} ₽</p>
                                <div class="flex items-center justify-end">
                                    <img
                                        src="../../../../public/storage/icons/icons8-просмотр-24.png"
                                        alt="Просмотры"
                                        width="24"
                                        height="24"
                                        class="w-6 h-6 mr-2"
                                    />
                                    <span class="text-gray-600">{{ ad.views }}</span>
                                </div>
                            </div>
                            <button v-if="added === false" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" @click="addToCart(ad)">
                                <div style="display: flex; align-items: center;">
                                    <span><img src="../../../../public/storage/icons/icons8-корзина-50.png" height="24" width="24"/></span>
                                    <span style="margin-left: 5px;">Добавить в корзину</span>
                                </div>
                            </button>
                            <button v-if="added === true" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" @click="deleteFromCart(ad)">
                                <div style="display: flex; align-items: center;">
                                    <span><img src="../../../../public/storage/icons/icons8-икс-50.png" height="24" width="24"/></span>
                                    <span style="margin-left: 5px;">Убрать из корзины</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script>
import slider from '@/Components/slider.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import NavLink from "@/Components/NavLink.vue";
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        AppLayout,
        Welcome,
        NavLink,
        Link,
        'v-slider': slider,
    },
    props: {
        ad: {
            type: Object,
        },
        added: {
            type: Boolean,
        }
    },
    methods: {
        async addToCart(ad) {
            try {
                const response = await axios.post(`/ad/${ad.id}/add_to_cart`);
                if (response.status === 200) {
                    this.added = true;
                    console.log(response.data.message);
                } else {
                    console.log("Произошла ошибка при добавлении в корзину.");
                }
            } catch (error) {
                console.error("Ошибка при добавлении в корзину:", error);
            }
        },

        async deleteFromCart(ad) {
            try {
                const response = await axios.post(`/ad/${ad.id}/remove_from_cart`);
                if (response.status === 200) {
                    this.added = false;
                    console.log(response.data.message);
                } else {
                    console.log("Произошла ошибка при удалении из корзины.");
                }
            } catch (error) {
                console.error("Ошибка при удалении из корзины:", error);
            }
        },

    },
    data() {
        return {
            added: this.added,
            options: {
                items: 1,
                margin: 5,
                nav: true,
                dots: true,
                loop: true,
                timing: 'cubic-bezier(0, 0.72, 0.64, 1.06)',
                offset: 1,
                prevNav: '&#60;',
                nextNav: '&#62;',
                sibling: true,
                responsive : {
                    0: {
                        items: 3
                    },
                    768: {
                        items: 1
                    },
                    999: {
                        items: 1
                    }
                }
            }
        };
    },
}
</script>


<style scoped>
.heart-img {
    width: 30px;
    height: 30px;
}

</style>
