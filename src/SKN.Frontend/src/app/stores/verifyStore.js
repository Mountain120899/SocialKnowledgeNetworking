import agent from "../api/agent";

export default class VerifyStore {
	//userRegistry = new Map<string, User>();
	result = undefined;
	verify = async (VerifyInformation) => {
		try {
			const result = await agent.Verify.verify(VerifyInformation);
			this.result = result;
		}
		catch (error) {
			console.log(error);
		}
	};
	getanswer = async (id) => {
		try {
			await agent.Verify.getanswer(id).then(result => {
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