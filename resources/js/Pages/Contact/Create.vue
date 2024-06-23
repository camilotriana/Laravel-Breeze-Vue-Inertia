<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import FileInput from "@/Components/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue"
import Swal from "sweetalert2";

const initialValues = {
    name: "",
    phone: "",
    avatar: null,
    privacity: "public",
};

const form = useForm(initialValues);

const onSelectAvatar = (e) => {
    //console.log(e.target.files);
    const file = e.target.files;

    if (file.length) {
        form.avatar = file[0];
    }
};

const submit = () => {
    form.post(route('contact.store'), {
        onSuccess: (e) => {
            Swal.fire({
                title: "Contacto creado exitosamente",
                icon: "success",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#198754"
            });
        }
    });
};

</script>

<template>
    <Head title="Crear contacto" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Crear Contacto
                </h2>
                <Link :href="route('contact.index')"> Lista de contactos </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <form class="w-1/2 py-5 space-y-3" @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Nombre" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                                placeholder="Ingrese su nombre"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div>
                            <InputLabel for="phone" value="Celular" />

                            <TextInput
                                id="phone"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                placeholder="Ingrese su número celular"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.phone"
                            />
                        </div>

                        <div>
                            <InputLabel for="avatar" value="Avatar" />

                            <FileInput name="avatar" @change="onSelectAvatar" />

                            <InputError
                                class="mt-2"
                                :message="form.errors.avatar"
                            />
                        </div>

                        <div>
                            <InputLabel for="privacity" value="Privacidad" />

                            <select
                                name="privacity"
                                id="privacity"
                                v-model="form.privacity"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            >
                                <option value="public">Público</option>
                                <option value="private">Privado</option>
                            </select>

                            <InputError
                                class="mt-2"
                                :message="form.errors.privacity"
                            />
                        </div>

                        <div class="flex justify-center">
                            <PrimaryButton>
                                Crear contacto
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
