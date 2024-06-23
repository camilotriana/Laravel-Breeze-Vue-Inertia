<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";

const page = usePage();
const contacts = ref(page.props.listContact);

const onSuccessDelete = (e) => {
    contacts.value = e.props.listContact;

    Swal.fire({
        title: "Contacto eliminado correctamente",
        icon: "success",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#198754",
    });
};
</script>

<template>
    <Head title="Contactos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Contactos
                </h2>
                <Link :href="route('contact.create')"> Crear contacto </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="relative overflow-x-auto">
                        <table
                            className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                className="text-xs text-gray-50 uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Celular
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Visibilidad
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Avatar
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Opciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="value in contacts"
                                    :key="value.id"
                                    className="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                >
                                    <th
                                        scope="row"
                                        className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ value.id }}
                                    </th>
                                    <td className="px-6 py-4">
                                        {{ value.name }}
                                    </td>
                                    <td className="px-6 py-4">
                                        {{ value.phone }}
                                    </td>
                                    <td className="px-6 py-4">
                                        {{ value.privacity }}
                                    </td>
                                    <td className="px-6 py-4">
                                        <img
                                            v-if="value.avatar != null"
                                            class="h-16"
                                            :src="`/storage/${value.avatar}`"
                                        />
                                    </td>
                                    <td className="px-6 py-4">
                                        <div class="space-x-4">
                                            <Link
                                                :href="
                                                    route(
                                                        'contact.edit',
                                                        value.id
                                                    )
                                                "
                                                >Editar</Link
                                            >
                                            <Link
                                                @success="onSuccessDelete"
                                                :href="
                                                    route(
                                                        'contact.destroy',
                                                        value.id
                                                    )
                                                "
                                                method="delete"
                                                as="button"
                                                >Eliminar</Link
                                            >
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
