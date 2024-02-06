<script>
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
    },
    props: {
        ads: {
            type: Object,
        }
    },
    async created() {
        console.log(this.items);
        try {
            const response = await axios.get('/ad/load_favorites');
            console.log(response);
            if (response.status === 200) {
                const favoritesIds = response.data.map(favorite => favorite.ad_id); // Замените 'ad_id' на реальное имя свойства, если оно отличается
                this.ads.forEach((ad) => {
                    ad.isHearted = favoritesIds.includes(ad.id);
                });
            } else {
                console.error("Failed to load favorite status.");
            }
        } catch (error) {
            console.error("Error loading favorite status:", error);
        }
    }
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Корзина
                </h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="ad in ads" :key="ad.id" class="border rounded-lg overflow-hidden shadow-lg">
                            <Link :href="`/ad/${ad.id}/show`">
                                <img :src="`/storage/${ad.img_1}`" alt="" class="w-full h-48 object-cover">
                            </Link>

                            <div class="p-4">
                                <div class="flex justify-between">
                                    <h3 class="text-lg font-semibold">{{ ad.header }}</h3>
                                    <div>
                                        <button class="heart-icon" @click="toggleHeart(ad)">
                                            <img
                                                v-if="!ad.isHearted"
                                                src="../../../../public/storage/icons/icons8-сердце-50.png"
                                                height="24"
                                                width="24"
                                                class="heart-img"
                                            />
                                            <img
                                                v-else
                                                src="../../../../public/storage/icons/icons8-сердце2-50.png"
                                                height="24"
                                                width="24"
                                                class="heart-img"
                                            />
                                        </button>
                                    </div>
                                </div>
                                <p class="text-gray-600">{{ ad.description }}</p>
                                <div class="mt-2 font-bold">Цена: {{ ad.price }}$</div>
                                <div class="text-sm text-gray-500">Просмотров: {{ ad.views }}</div>
                            </div>
                            <div class="flex justify-between mt-4">
                                <Link :href="`ad/${ad.id}/edit`" class="font-medium py-1 px-4 rounded focus:outline-none focus:shadow-outline">
                                  <span class="edit-icon">
                                    <img src="../../../../public/storage/icons/icons8-редактировать-48.png" height="30" width="30"/>
                                  </span>
                                </Link>
                                <button @click="deleteAd(ad)" class="font-medium py-1 px-4 rounded focus:outline-none focus:shadow-outline">
                                    <span class="edit-icon">
                                    <img src="../../../../public/storage/icons/icons8-кнопка-удалить-50.png" height="30" width="30"/>
                                  </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
.heart-icon {
    cursor: pointer;
    display: inline-block;
}

.heart-img {
    transition: transform 0.3s ease-in-out;
}

.heart-img:hover {
    transform: scale(1.2); /* Увеличиваем изображение при наведении */
}

.edit-icon {
    display: inline-block;
    position: relative;
    width: 25px;
    height: 25px;
}

.static-icon {
    position: absolute;
    top: 0;
    left: 0;
    transition: opacity 0.3s ease-in-out;
}

.hover-icon {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.edit-icon:hover .static-icon {
    opacity: 0;
}

.edit-icon:hover .hover-icon {
    opacity: 1;
}
</style>
