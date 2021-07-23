import agent from "../api/agent";

export default class UserStore {
	//userRegistry = new Map<string, User>();

    currentUser = undefined;
	loading = false;
	loadingInitial = false;

	get isShowLoading() {
		return this.loadingInitial;
	}

	login = async (loginAccount) => {
		try {
			console.log("aaaa",loginAccount);
			const user = await agent.User.insert(loginAccount);
			this.currentUser = user;
		} catch (error) {
			console.log(error);
		}
		return this.currentUser;
	};
}