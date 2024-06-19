import { ref } from "vue";
import { IMember } from "../../member/interfaces/MemberInterface";
import { showError } from "../../../../helpers/toastNotification";
import { storeToRefs } from "pinia";
import { taskStore } from "../store/kaban";

export function useSelectMember() {
    const selectedMembers = ref<IMember[]>([]);
    const { task } = storeToRefs(taskStore);

    function selectMember(member: IMember) {
        const isExist = selectedMembers.value.filter(memberItem => memberItem.id === member.id);

        if (isExist.length === 0) {
            selectedMembers.value.push({
                id: member.id,
                name: member.name,
                email: member.email,
            });
            task.value.member_id.push(member.id);
        } else {
            showError("El miembro ya ha sido seleccionado.");
        }
    }

    function unSelectMember(memberId: string) {
        const filteredMembers = selectedMembers.value.filter(memberItem => memberItem.id !== memberId);
        const filteredMembersIds = task.value.member_id.filter(memberIdItem => memberIdItem !== memberId);
        task.value.member_id = filteredMembersIds;
        selectedMembers.value = filteredMembers
    }

    function clearSelectedMembers() {
        selectedMembers.value = [];
    }

    return { selectedMembers, selectMember, unSelectMember, clearSelectedMembers };
}