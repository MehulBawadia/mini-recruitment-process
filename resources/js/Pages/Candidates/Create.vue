<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import FormInput from '@/Components/FormInput.vue';
import CustomForm from '@/Components/CustomForm.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
    components: {
        BreezeAuthenticatedLayout,
        CustomForm, FormInput,
        Head, Link, Swal, Datepicker,
    },

    props: {
        agencies: Object,
    },

    data() {
        return {
            errors: null,
            processing: false,
            form: {
                name: '',
                email: '',
                mobile: '',
                comments: '',
                interview_by: '',
                interview_feedback: '',
                interview_scheduled_at: '',
                is_selected: '',
                agency_id: '',
                cv_resume_file: '',
            },
        };
    },

    methods: {
        addFile(e) {
            this.form.cv_resume_file = e.target.files[0];

            if (e.target.files[0].type !== 'application/pdf') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error !',
                    text: 'Only PDF files can be uploaded.',
                });

                this.form.cv_resume_file = "";
            }
        },

        addCandidate() {
            this.processing = true;

            let formData = new FormData();
            for (const key in this.form) {
                formData.append(key, this.form[key]);
            }

            axios.post(route('candidates.store'), formData)
                .then(res => {
                    this.processing = false;

                    if (res.data.status === 'success') {
                        this.clearForm();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success !',
                            text: res.data.message,
                            timer: 2000,
                        });

                        this.errors = null;

                        setTimeout(() => {
                            window.location = route('candidates.index');
                        }, 2150);
                    }
                }).catch(error => {
                    this.processing = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },

        clearForm() {
            let self = this;
            Object.keys(this.form).forEach(function (key, index) {
                self.form[key] = '';
            });
            self.errors = null;
        }
    },
};
</script>

<template>
    <Head title="Add New Candidate" />

    <BreezeAuthenticatedLayout>
        <h1 class="text-3xl font-bold">
            <Link class="breadcrumbLink" :href="route('candidates.index')">
                Candidates
            </Link>
            / Add
        </h1>

        <div v-if="this.errors" class="max-w-5xl bg-red-200 text-red-800 py-4 px-4 rounded mt-6">
            Oops! There were some errors while creating the agency.
        </div>

        <div class="max-w-5xl bg-white rounded-md shadow overflow-x-auto mt-8">
            <CustomForm formType="create" @store="addCandidate" submitButtonText="Add Candidate" :processing="this.processing">
                <template #formFields>
                    <div class="px-10 py-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <FormInput
                                labelText="Name:"
                                labelFor="name"
                                v-model="this.form.name"
                                :error="this.errors && this.errors.name"
                                isRequired
                            />

                            <div>
                                <label for="agency_id" class="block font-semibold text-gray-700">
                                    Select Agency:
                                </label>

                                <select v-model="this.form.agency_id" id="agency_id" class="form-select block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-400 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option v-for="(agency, id) in agencies" :value="id" :key="id">{{ agency }}</option>
                                </select>

                                <span class="text-red-600" v-if="this.errors && this.errors.agency_id">{{ this.errors.agency_id[0] }}</span>
                            </div>

                            <FormInput
                                labelText="E-Mail:"
                                labelFor="email"
                                inputType="email"
                                v-model="this.form.email"
                                :error="this.errors && this.errors.email"
                                isRequired
                            />

                            <FormInput
                                labelText="Mobile:"
                                labelFor="mobile"
                                v-model="this.form.mobile"
                                :error="this.errors && this.errors.mobile"
                                isRequired
                            />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                            <FormInput
                                labelText="CV / Resume:"
                                labelFor="cv_resume_file"
                                inputType="file"
                                class="py-2"
                                v-model="this.form.cv_resume_file"
                                :error="this.errors && this.errors.cv_resume_file"
                                isRequired
                                @change="addFile"
                            />

                            <div class="flex items-center">
                                <label for="is_selected" class="mt-5 block font-semibold text-gray-700">
                                    <input type="checkbox" class="form-checkbox rounded focus:outline-none focus:ring-0" id="is_selected" value="1" v-model="this.form.is_selected" />

                                    <span class="ml-2">Is Selected</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="comments" class="block font-semibold text-gray-700">
                                Comments
                            </label>
                            <textarea
                                id="comments"
                                rows="3"
                                v-model="this.form.comments"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-400 focus:ring-opacity-50 rounded-md shadow-sm"
                                :class="{'border-red-500' : this.errors && this.errors.comments}"
                            ></textarea>

                            <span class="text-red-600" v-if="this.errors && this.errors.comments">{{ this.errors.comments[0] }}</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                            <FormInput
                                labelText="Interview By:"
                                labelFor="interview_by"
                                v-model="this.form.interview_by"
                                :error="this.errors && this.errors.interview_by"
                                isRequired
                            />

                            <div class="mt-1">
                                <label for="interview_scheduled_at" class="block font-semibold text-gray-700">
                                    Interview Scheduled At:
                                    <span class="text-red-500">*</span>
                                </label>
                                <Datepicker
                                    id="interview_scheduled_at"
                                    inputClassName="mt-0.5"
                                    v-model="this.form.interview_scheduled_at"
                                    :minDate="new Date()"
                                    :disabledWeekDays="[0]"
                                    :state="this.errors && this.errors.interview_scheduled_at?.length >= 1 ? false : null"
                                    :is24="false"
                                    utc
                                    required
                                />

                                <span class="text-red-600" v-if="this.errors && this.errors.interview_scheduled_at">{{ this.errors.interview_scheduled_at[0] }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="interview_feedback" class="block font-semibold text-gray-700">
                                Interview Feedback:
                            </label>
                            <textarea
                                id="interview_feedback"
                                rows="3"
                                v-model="this.form.interview_feedback"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-400 focus:ring-opacity-50 rounded-md shadow-sm"
                                :class="{'border-red-500' : this.errors && this.errors.interview_feedback}"
                            ></textarea>

                            <span class="text-red-600" v-if="this.errors && this.errors.interview_feedback">{{ this.errors.interview_feedback[0] }}</span>
                        </div>
                    </div>
                </template>
            </CustomForm>
        </div>
    </BreezeAuthenticatedLayout>
</template>
