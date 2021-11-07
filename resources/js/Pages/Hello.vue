<script>
export default {
    props: {
        messages: Array,
        errors: Object,
    },
    data() {
        return {
            working: false,
            form: { message: "" },
        };
    },
    methods: {
        addMessage() {
            if (this.working) return;

            this.working = true;
            this.$inertia.post("/messages", this.form, {
                onSuccess: () => {
                    this.form.message = "";
                },
                onFinish: () => {
                    this.working = false;
                },
            });
        },
    },
};
</script>

<template>
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-center mt-6 mb-10">Your messages</h1>

        <form @submit.prevent="addMessage" class="mb-8 relative">
            <textarea
                name="message"
                id="message"
                cols="30"
                rows="10"
                placeholder="Your message here"
                class="bg-gray-50 w-full rounded p-4 h-32 resize-none"
                v-model="form.message"
            ></textarea>
            <span
                class="text-red-500 font-bold text-sm absolute -bottom-4 left-0"
                v-if="errors.text"
                >{{ errors.text }}</span
            >

            <button
                type="submit"
                class="
                    absolute
                    right-4
                    bottom-4
                    bg-indigo-500
                    text-white
                    uppercase
                    font-bold
                    tracking-wide
                    px-8
                    py-2
                    rounded
                "
                :disabled="working"
            >
                {{ working ? "Sending..." : "Send" }}
            </button>
        </form>

        <ul class="space-y-4">
            <li
                class="bg-gray-50 p-4 rounded"
                v-for="message in messages"
                :key="message.id"
            >
                {{ message.text }}
            </li>
        </ul>
    </div>
</template>
