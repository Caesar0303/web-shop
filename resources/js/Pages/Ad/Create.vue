<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Создание объявления
                </h2>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Категория</label>
                            <select id="category_id" v-model="category_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <!-- Здесь должны быть опции категорий, полученные с сервера -->
                            </select>
                        </div>

                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700">Город</label>
                            <select id="city_id" v-model="city_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <!-- Здесь должны быть опции городов, полученные с сервера -->
                            </select>
                        </div>

                        <div>
                            <label for="header" class="block text-sm font-medium text-gray-700">Заголовок</label>
                            <input type="text" id="header" v-model="header" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                            <textarea id="description" v-model="description" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Номер телефона</label>
                            <input type="text" id="phone_number" v-model="phone_number" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Количество</label>
                            <input type="number" id="quantity" v-model="quantity" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                            <input type="number" id="price" v-model="price" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>

                        <div>
                            <label for="img_1" class="block text-sm font-medium text-gray-700">Изображение 1</label>
                            <input type="file" id="img_1" @change="handleFileUpload($event, 'img_1')" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <label for="img_2" class="block text-sm font-medium text-gray-700">Изображение 2</label>
                            <input type="file" id="img_2" @change="handleFileUpload($event, 'img_2')" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <label for="img_3" class="block text-sm font-medium text-gray-700">Изображение 3</label>
                            <input type="file" id="img_3" @change="handleFileUpload($event, 'img_3')" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <button type="submit" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Создать
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        AppLayout,
        Link,
    },
    data() {
        return {
            category_id: '',
            city_id: '',
            header: '',
            img_1: '',
            img_2: '',
            img_3: '',
            description: '',
            phone_number: '',
            quantity: 0,
            price: 0,
        }
    },
    methods: {
        handleFileUpload(event, imageName) {
            const file = event.target.files[0];
            this[imageName] = file;
        },
        submit() {
            const formData = new FormData();
            formData.append('category_id', this.category_id);
            formData.append('city_id', this.city_id);
            formData.append('header', this.header);
            formData.append('description', this.description);
            formData.append('phone_number', this.phone_number);
            formData.append('quantity', this.quantity);
            formData.append('price', this.price);
            if (this.img_1) formData.append('img_1', this.img_1);
            if (this.img_2) formData.append('img_2', this.img_2);
            if (this.img_3) formData.append('img_3', this.img_3);

            axios.post('/ad/store', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    window.location.href="/dashboard";
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    },
}

</script>
