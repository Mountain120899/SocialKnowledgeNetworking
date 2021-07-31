import agent from "../api/agent";

export default class UserInfomationStore {
	//userRegistry = new Map<string, User>();

    result = undefined;

	get isShowLoading() {
		return this.loadingInitial;
	}

	getUserInfomation = async (UserId,Type) => {
		try {
			const user = await agent.UserInformation.getUserInformation(UserId,Type).then(result => {
				this.result = result;
			});
			return this.result;
		}
		catch (error) {
			console.log(error);
			return [];
		}
	}

	
}