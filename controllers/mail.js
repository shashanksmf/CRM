//var inspinia = angular.module('inspinia');
inspinia.controller('mailCtrl', ['$scope', '$rootScope', '$http', '$q', 'API',
	'$state', '$timeout', '$sce',
	function($scope, $rootScope, $http, $q, API, $state, $timeout, $sce) {

		$scope.isShowTemplate = false;



		API.getAllCampaigns().then(function(response) {
			if (response.data.result) {
				$scope.campaigns = response.data.camp;
			}
		})

		API.getAllGroups().then(function(response) {
			if (response.data.result) {
				$scope.groups = response.data;
			}
		})

		$scope.deleteCampaign = function(campaignId) {

			if (!campaignId || campaignId.length == 0) {
				// alert("Campaign has not been assigned any Id");
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"Campaign has not been assigned any Id";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
				return;
			}

			API.deleteCampaign({
				id: campaignId
			}).then(function(response) {
				if (response.data.hasOwnProperty("result") && response.data.result) {
					for (var i = 0; i < $scope.campaigns.length; i++) {
						if (campaignId == $scope.campaigns[i].id) {
							$scope.campaigns.splice(i, 1);
							// alert("Campaign Deleted Successfully");
							$rootScope.config.rootModalShow = true;
							$rootScope.config.rootModalHeader = "Success";
							$rootScope.config.responseText = "Campaign Deleted Successfully ";
							$rootScope.config.rootModalAction = function() {
								$rootScope.config.rootModalShow = false;
							};
						}
					}
				} else if (response.data.hasOwnProperty("reason")) {
					// alert(response.data.details);
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText = response.data.reason;
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
				} else {
					// alert("Something Wrong with the server");
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText =
						"Something Wrong with the server ";
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
				}
			})
		}


		var SMSdata = {
			"from": "InfoSMS",
			"to": "+918983485655",
			"text": "My first Infobip SMS"
		};

		var multiSms = {
			"messages": [{
					"from": "InfoSMS",
					"to": "+918983485655",
					"text": "Yoo Infobip SMS"
				}
				// {
				//    "from":"FromShasahnk",
				//    "to":"+918989012123",
				//    "text":"Hello Anil how are You?"
				// },
				// {
				//    "from":"FromShashank",
				//    "to":"+919589496829",
				//    "text":"Hello Jitu how are you?"
				// }
			]
		}


		$scope.sendSMS = function(groupObj) {
			//console.log(groupObj);

			if (!groupObj || !groupObj.id) {
				// alert("Please select group");
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"Please select group";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
				return;
			} else if (groupObj.Members.length <= 0) {
				// alert("No Members in group");
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"No members in group ";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
			} else {

				var msgObj = {
					"messages": []
				};
				groupObj.Members.forEach(function(item) {
					if (item && item.phone && item.phone.length > 1) {
						item.phone = item.phone.trim();
						msgObj.messages.push({
							"from": $scope.smsSenderName,
							"to": item.phone.charAt(0) !== "+" ? "+" + item.phone : item.phone,
							"text": $scope.smsText
						});
					}
				});
				if (msgObj.messages.length <= 0) {
					// alert("No Phone Numbers attached to Members");
					$rootScope.config.rootModalShow = true;
					$rootScope.config.rootModalHeader = "Failed";
					$rootScope.config.responseText =
						"No Phone number attached to members";
					$rootScope.config.rootModalAction = function() {
						$rootScope.config.rootModalShow = false;
					};
					return;
				}
				console.log(msgObj);
				//	console.log(phNoArr);
				var smsResObj = {
					"res": []
				};
				for (var i = 0; i < msgObj.messages.length; i++) {
					API.sendSMS(msgObj.messages[i]).then(function(res) {
						console.log("sms response", res);
						msgObj.messages.push(res);
					});
				}
				if (smsResObj.res.length > 0) {
					$('#sendSMSModal').modal('hide');
				}

				//var encoded = "VVBTQUlMMTpVMjQyODk3bA==";
				// var encoded = "VVBTQUlsMTpVMjQyODk3bA==";
				// $.ajax({
				// 			type:"POST",
				// 			//url:"https://api.infobip.com/sms/1/text/single",
				// 			url:"https://api.infobip.com/sms/1/text/multi",
				// 			headers:{
				// 				"Authorization": "Basic "+encoded,
				// 				"Content-Type":"application/json",
				// 				"Accept":"application/json"
				// 			},
				// 			data:JSON.stringify(msgObj),
				// 			success:function(response){
				// 				console.log("response",response);
				// 				API.saveSmsCampaign({ data : response, groupid: groupObj.id, name: groupObj.name || "SMS" }).then(function(res){
				// 					console.log("sms db save res",res);
				// 				})
				// 			}

				// 		})

			}

			return;



			var data = JSON.stringify({
				"from": "InfoSMS",
				"to": "+918983485655",
				"text": "Test SMS."
			});

			var xhr = new XMLHttpRequest();
			xhr.withCredentials = false;

			xhr.addEventListener("readystatechange", function() {
				if (this.readyState === this.DONE) {
					console.log(this.responseText);
				}
			});

			xhr.open("POST", "https://api.infobip.com/sms/1/text/single");
			xhr.setRequestHeader("authorization",
				"Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==");
			xhr.setRequestHeader("content-type", "application/json");
			xhr.setRequestHeader("accept", "application/json");

			xhr.send(data);
			// alert("Please wait until we provide you API key");
			$rootScope.config.rootModalShow = true;
			$rootScope.config.rootModalHeader = "Failed";
			$rootScope.config.responseText =
				"please wait until we provide your API key";
			$rootScope.config.rootModalAction = function() {
				$rootScope.config.rootModalShow = false;
			};
		}

		var mailData = {
			to: "shankie1990@gmail.com",
			toName: "shashank Jaiswal",
			subject: "testing MailChimp"
		};

		$scope.sendMail = function() {

			API.sendMail(mailData).then(function(response) {
				console.log(response);

			})

		}


		API.getTemplate().then(function(response) {

			if (response.data.result) {
				var templateStr = JSON.stringify(response.data).replace(/\r?\n|\r/g,
					'');
				var str = ((JSON.parse(templateStr)).replace(/\r?\n|\r/g, ''));
				$scope.templateObj = JSON.parse(str);
			}
			//var html = decodeHtml(htmlObj.templ[0].html);
			//$(html).children().find("#changeContent table > tbody > tr > td > p ").eq(1).html($scope.campaignMessage);
			//$scope.htmlTemplate = $sce.trustAsHtml(html);
			//console.log($scope.htmlTemplate);
		})


		$scope.previewTemplate = function() {

			$scope.isShowTemplate = true;
			//alert($scope.campaignMessage);
			var html = decodeHtml($scope.templateObj.templ[0].html);
			$scope.htmlTemplate = $sce.trustAsHtml(html);
			$timeout(function() {
				//  document.querySelectorAll("#changeContent table tr td")[0].children[2].innerHTML = '';
				document.querySelectorAll("#changeContent table tr td")[0].children[
						2]
					.remove();
				//   document.querySelectorAll("#changeContent table tr td")[0].children[3].innerHTML = '';
				document.querySelectorAll("#changeContent table tr td")[0].children[
						2]
					.remove();
				document.querySelectorAll("#changeContent table tr td")[0].children[
						2]
					.remove();

				document.querySelectorAll("#changeContent table tr td")[0].children[
						1]
					.innerHTML = $scope.campaignMessage || '';

				//	console.log(document.querySelectorAll("#changeContent table tr td")[0].children[1].innerHTML)
			}, 10);


		}

		$scope.hideTemplatePreview = function() {
			$scope.isShowTemplate = false;
		}

		function decodeHtml(html) {
			var txt = document.createElement("textarea");
			txt.innerHTML = html;
			return txt.value;
		}

		//	$scope.addCampaignSubmit();
		$scope.addCampaignSubmit = function() {
	alert("You have exceeded the limits of sending");
	return;
			if (!$scope.campaignName) {
				// alert("Please Enter Campaign Name");
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"please enter Campaign Name";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
				return;
			} else if (!$scope.groupSelected.id) {
				// alert("Please Select Group");
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"please select Group";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
				return;
			} else if (!$scope.groupSelected.segId || $scope.groupSelected.segId.length ==
				0) {
				// alert(
				// "Mailchimp Segment Id not created, Please create segment for this group by updating the group"
				// );
				$rootScope.config.rootModalShow = true;
				$rootScope.config.rootModalHeader = "Failed";
				$rootScope.config.responseText =
					"Mailchimp Segment Id not created, Please create segment for this group by updating the group";
				$rootScope.config.rootModalAction = function() {
					$rootScope.config.rootModalShow = false;
				};
				return;
			}

			$scope.formData = new FormData();
			$scope.formData.append("groupId", $scope.groupSelected.id);
			$scope.formData.append("name", $scope.campaignName);
			$scope.formData.append("createdBy", $rootScope.userName || localStorage
				.getItem(
					"userName") || "Admin");
			$scope.formData.append("emails", $rootScope.userEmail || localStorage.getItem(
				"userName") || "shashanksmf@outlook.com");
			$scope.formData.append("subject", $scope.campaignEmailSubject);
			$scope.formData.append("body", $scope.campaignMessage);
			$scope.formData.append("templateId", "2");
			$scope.formData.append("segId", $scope.groupSelected.segId);
			$scope.formData.append("dates", new Date());

			API.addCampaign($scope.formData).then(function(response) {
				console.log(response);
				if (response.data.responce) {
					$scope.campaignId = response.data.id;

					console.log("run campaign");

					API.runCampaign($scope.campaignId).then(function(response) {
							console.log(response);
							if (response.data.responce) {
								// alert("campaign Successfully started");
								// location.reload();
								$rootScope.config.rootModalShow = true;
								$rootScope.config.rootModalHeader = "Success";
								$rootScope.config.responseText =
									"Campaign Successfully started";
								$rootScope.config.rootModalAction = function() {
									$rootScope.config.rootModalShow = false;
								};
							}
							else {
								alert("You have exceeded the limits of sending");
								// $rootScope.config.rootModalShow = false;
								// $rootScope.config.rootModalHeader = "Failed";
								// $rootScope.config.responseText =
								// 	"You have exceeded the limits of sending";
								// $rootScope.config.rootModalAction = function() {
								// 	$rootScope.config.rootModalShow = false;
								// };
							}
						},
						function(data) {
							// alert("campaign Successfully started");
							$rootScope.config.rootModalShow = true;
							$rootScope.config.rootModalHeader = "Success";
							$rootScope.config.responseText =
								"Campaign Successfully started";
							$rootScope.config.rootModalAction = function() {
								$rootScope.config.rootModalShow = false;
							};
							// Handle error here
							// location.reload();
						})
				}

			})

		}

	}
])
