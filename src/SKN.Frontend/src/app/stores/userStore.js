import agent from "../api/agent";

export default class UserStore {
	//userRegistry = new Map<string, User>();

    currentUser = undefined;
	loading = false;
	loadingInitial = false;

	get isShowLoading() {
		return this.loadingInitial;
	}

	getCurrentUser = async (username) => {
		try {
			const user = await agent.User.info(username);
			this.currentUser = user;
		} catch (error) {
			console.log(error);
		}
		return this.currentUser;
	}

	login = async (loginAccount) => {
		try {
			const user = await agent.User.insert(loginAccount);
			this.currentUser = user;
		} catch (error) {
			console.log(error);
		}
		return this.currentUser;
	};
}