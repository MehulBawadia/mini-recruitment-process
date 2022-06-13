<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import moment from 'moment';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
        Head, Link
    },

    props: {
        candidate: Object,
        cvResumeFile: String,
    },

    data() {
        return {
            successMessage: null,
            isDestroying: false,
        }
    },

    methods: {
        moment(date) {
            return moment(date);
        },

        destroyCandidate() {
            this.isDestroying = true;

            Swal.fire({
                icon: 'question',
                title: 'Confirm',
                text: 'Are you want to delete this candidate?',
                showConfirmButton: true,
                confirmButtonText: 'Yes! Delete',
                showCancelButton: true,
                cancelButtonText: 'No',
            }).then(btnResult => {
                if (btnResult.isDismissed) {
                    this.isDestroying = false;
                }

                if (btnResult.isConfirmed) {
                    axios.delete(route('candidates.destroy', this.candidate.id))
                        .then(res => {
                            if (res.data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success !',
                                    text: res.data.message,
                                    timer: 2000,
                                });

                                setTimeout(() => {
                                    window.location = route('candidates.index');
                                }, 2500);
                            }
                        });
                }
            });
        }
    },
}
</script>

<template>
    <Head title="Candidate Details" />

    <BreezeAuthenticatedLayout>
        <h1 class="text-3xl font-bold">
            <Link class="breadcrumbLink" :href="route('candidates.index')">
                Candidates
            </Link>
            / {{ this.candidate.name }}
        </h1>

        <div class="max-w-5xl bg-white rounded-md shadow overflow-x-auto mt-8">
            <div class="px-10 py-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <div class="font-semibold text-gray-600">Name:</div>
                        <div class="font-semibold">{{ this.candidate.name }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Agency:</div>
                        <div class="font-semibold" v-if="this.candidate.agency">
                            <Link :href="route('agencies.show', this.candidate.agency_id)" class="text-indigo-600 hover:text-indigo-800 focus:text-indigo-800 focus:focus:outline-none transition ease-in-out duration-150">{{ this.candidate.agency.name }}</Link>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">E-Mail:</div>
                        <div class="font-semibold">{{ this.candidate.email }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Mobile:</div>
                        <div class="font-semibold">{{ this.candidate.mobile }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">CV / Resume:</div>
                        <div class="font-semibold" v-if="this.cvResumeFile">
                            <a :href="this.cvResumeFile" target="_blank" class="text-indigo-600 hover:text-indigo-800 focus:text-indigo-800 focus:focus:outline-none transition ease-in-out duration-150">View / Download</a>
                        </div>
                        <div class="font-semibold" v-else>No CV/Resume file uploaded.</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Is Selected:</div>
                        <div class="font-semibold">{{ this.candidate.is_selected === 0 ? 'Yes' : 'No' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Comments:</div>
                        <div class="font-semibold">{{ this.candidate.comments }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Interview By:</div>
                        <div class="font-semibold">{{ this.candidate.interview_by }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Interview Scheduled At:</div>
                        <div class="font-semibold">
                            {{ moment(this.candidate.interview_scheduled_at).format('Do MMM, YYYY hh:mm A') }}
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Interview Feedback:</div>
                        <div class="font-semibold">{{ this.candidate.interview_feedback }}</div>
                    </div>
                </div>
            </div>

            <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex items-center justify-between">
                <button class="text-red-600 hover:text-red-800 focus:text-red-800 focus:outline-none transition ease-in-out duration-150" @click.prevent="destroyCandidate" :class="{ 'opacity-25': this.isDestroying }">Destroy Candidate</button>

                <Link class="font-bold inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md text-sm text-white tracking-widest hover:bg-amber-600 focus:bg-amber-600 focus:outline-none transition ease-in-out duration-150" :href="route('candidates.edit', this.candidate.id)">
                    <span>Edit</span>
                    <span class="hidden md:inline">&nbsp;Candidate</span>
                </Link>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
